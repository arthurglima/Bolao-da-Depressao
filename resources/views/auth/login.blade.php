@extends('layouts.app')

@section('content')

    <div class="container" style="margin-top: 90px">
        <div class="row justify-content-center">
            <div class="col-md-8" style="    margin-left: -150px;">
                <div class="card-group">
                    <div class="card p-4">
                        <form class="card-body" method="POST" action="{{ route('login') }}">
                            @csrf
                            <h1>{{ __('Login') }}</h1>
                            <p class="text-muted">Entre em sua conta</p>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="icon-user"></i>
                                    </span>
                                </div>
                                <input id="email" type="email"
                                       placeholder="Entre com e-mail"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="icon-lock"></i>
                                    </span>
                                </div>
                                <input id="password" type="password"
                                       placeholder="Entre com a senha"
                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <button class="btn btn-primary px-4" type="submit">Entrar</button>
                                </div>
                                <div class="col-6 text-right">
                                    {{--@if (Route::has('password.request'))--}}
                                        {{--<a class="btn btn-link" href="{{ route('password.request') }}">--}}
                                            {{--{{ __('Esqueceu a senha?') }}--}}
                                        {{--</a>--}}
                                    {{--@endif--}}
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
                        <div class="card-body text-center">
                            <div>
                                <h2>Registre-se</h2>
                                <p>Temos muitas outras vantagens e estamos sempre criando novas melhorias. Crie seu
                                    bolão
                                    grátis e comprove!</p>
                                @if (Route::has('register'))
                                    <a class="btn btn-primary active mt-3" href="{{ route('register') }}" type="button">
                                        Registre-se agora!
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
