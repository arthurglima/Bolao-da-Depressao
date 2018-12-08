<?php

namespace App\Http\Middleware;

use App\SisBolao\Administrador;
use Closure;

class RouteIsAllowed
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Closure $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    if ($request->user()->getType() == Administrador::ADMINISTRADOR) {
      return $next($request);
    } else {
      abort(404);
    }
  }
}
