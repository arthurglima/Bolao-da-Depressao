<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class Bolao extends Model
{
  protected $table = 'bolao';


  protected $fillable = [
    'nome', 'data_inicio', 'is_moderado', 'can_buscar', 'campeonato_id',
    'valor_premiacao', 'pontos_placar', 'pontos_gol_vencedor', 'pontos_gol_perdedor',
    'desempate'
  ];

  /**
   * Retorna a classificação de usuários de um bolão
   * @return mixed
   */
  public function getClassificacao()
  {
    $list = DB::select(DB::raw("
        SELECT
          `users`.`id`,
          `users`.`name`,
          `users`.`email`,
          `b`.`desempate`,
          `b`.`pontos_placar`,
          `b`.`pontos_gol_vencedor`,
          `b`.`pontos_gol_perdedor`,
          (SELECT count(palpite.id)
           FROM `palpite`
             INNER JOIN `jogo` AS `j`
               ON `palpite`.`jogo_id` = `j`.`id` AND `palpite`.`palpite_mandante` = `j`.`resultado_mandante` AND
                  `palpite`.`palpite_visitante` = `j`.`resultado_visitante`
           WHERE `palpite`.`bolao_has_user_bolao_id` = {$this->id} AND `palpite`.`bolao_has_user_users_id` = users.id) *
          b.pontos_placar       AS placar,
          (SELECT count(palpite.id)
           FROM `palpite`
             INNER JOIN `jogo` AS `j` ON `palpite`.`jogo_id` = `j`.`id` AND (
               (`palpite`.`palpite_mandante` = `j`.`resultado_mandante` AND
                `palpite`.`palpite_mandante` >= `j`.`resultado_visitante`) OR
               (`palpite`.`palpite_visitante` = `j`.`resultado_visitante` AND
                `palpite`.`palpite_visitante` >= `j`.`resultado_mandante`))
           WHERE `palpite`.`bolao_has_user_bolao_id` = {$this->id} AND `palpite`.`bolao_has_user_users_id` = users.id) *
          b.pontos_gol_vencedor AS gols_vencedor,
          (SELECT count(palpite.id)
           FROM `palpite`
             INNER JOIN `jogo` AS `j` ON `palpite`.`jogo_id` = `j`.`id` AND (
               (`palpite`.`palpite_mandante` = `j`.`resultado_mandante` AND
                `palpite`.`palpite_mandante` <= `j`.`resultado_visitante`) OR
               (`palpite`.`palpite_visitante` = `j`.`resultado_visitante` AND
                `palpite`.`palpite_visitante` <= `j`.`resultado_mandante`))
           WHERE `palpite`.`bolao_has_user_bolao_id` = {$this->id} AND `palpite`.`bolao_has_user_users_id` = users.id) *
          b.pontos_gol_perdedor AS gols_perdedor,
            (SELECT sum(timestampdiff(MINUTE, timestamp(palpite.created_at), timestamp(CONCAT(j.data_jogo, ' ', j.hora_jogo))))
             FROM `palpite`
               INNER JOIN `jogo` AS `j` ON `palpite`.`jogo_id` = `j`.`id`
             WHERE `palpite`.`bolao_has_user_bolao_id` = {$this->id} AND `palpite`.`bolao_has_user_users_id` = users.id)
                                                                AS minutos_palpite,
            (SELECT count(*)
             FROM `palpite`
               INNER JOIN `jogo` AS `j` ON `palpite`.`jogo_id` = `j`.`id`
             WHERE (`palpite`.`bolao_has_user_bolao_id` = {$this->id}
                   AND `palpite`.`bolao_has_user_users_id` = users.id)
                   AND palpite.created_at <> palpite.updated_at) AS editou_palpite
        FROM `users`
          INNER JOIN `bolao_has_user` AS `bhu` ON `users`.`id` = `bhu`.`users_id` AND `bhu`.`bolao_id` = {$this->id}
          INNER JOIN `bolao` AS `b` ON `bhu`.`bolao_id` = `b`.`id`
        WHERE `bhu`.`esta_aprovado` = 1
        ORDER BY
            placar DESC,
            gols_vencedor DESC,
            gols_perdedor DESC,
            minutos_palpite IS NULL ASC,
            CASE WHEN b.desempate = 0
              THEN minutos_palpite END DESC,
            CASE WHEN b.desempate = 1
              THEN -minutos_palpite END DESC,
          
            CASE WHEN b.desempate = 2
              THEN -editou_palpite END DESC,
            CASE WHEN b.desempate = 2
              THEN minutos_palpite END DESC,
          
            CASE WHEN b.desempate = 3
              THEN -editou_palpite END DESC,
            CASE WHEN b.desempate = 3
              THEN -minutos_palpite END DESC
    "));

    $list = new LengthAwarePaginator($list, count($list), 10, 1);
    return $list;
  }


  /**
   * Retorna todos os possiveis jogo para a rodada corrente
   */
  public function getPossiveisJogosDaRodada(): array
  {
    $query = [];
    if (isset($this->id) && isset(Auth::user()->id)) {
      $query = DB::select(DB::raw("
          SELECT
            p.id,
            p.palpite_mandante,
            p.palpite_visitante,
            j.resultado_mandante,
            j.resultado_visitante,
            j.id as jogo_id,
            j.data_jogo,
            j.hora_jogo,
            js.nome          AS status_nome,
            mandante.nome    AS mandante_nome,
            mandante.alias   AS mandante_alias,
            mandante.escudo  AS mandante_escudo,
            visitante.nome   AS visitante_nome,
            visitante.alias  AS visitante_alias,
            visitante.escudo AS visitante_escudo,
            f.nome as rodada
          FROM jogo AS j
            LEFT JOIN palpite AS p 
                ON p.jogo_id = j.id AND p.bolao_has_user_users_id = " . Auth::user()->id . " 
                                    AND p.bolao_has_user_bolao_id = {$this->id}
            INNER JOIN time AS mandante ON mandante.id = j.time_id_mandante
            INNER JOIN time AS visitante ON visitante.id = j.time_id_visitante
            INNER JOIN jogo_status AS js ON js.id = j.jogo_status_id
            INNER JOIN fase f ON
                                (j.fase_campeonato_id = f.campeonato_id
                                 AND curdate() BETWEEN f.data_inicial AND f.data_final)
          where (curdate() < j.data_jogo or (curdate() = j.data_jogo and curtime() < j.hora_jogo))
          ORDER BY data_jogo DESC, hora_jogo DESC
    "));
    }
    return $query;
  }
}
