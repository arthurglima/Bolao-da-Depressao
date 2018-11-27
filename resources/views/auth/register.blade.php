@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 90px">
        <div class="row justify-content-center">
            <div class="col-md-6" style="    margin-left: -150px;">
                <div class="card mx-4">
                    <form class="card-body p-4" method="POST" action="{{ route('register') }}">
                        @csrf
                        <h1>Registrar-se</h1>
                        <p class="text-muted">Crie sua conta</p>
                        <div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="icon-user"></i>
                              </span>
                                </div>
                                <input id="name" type="text" placeholder="Nome Completo"
                                       class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                       name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">@</span>
                                </div>
                                <input id="email" type="email"
                                       placeholder="E-mail"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="icon-lock"></i>
                              </span>
                                </div>
                                <input id="password" type="password"
                                       placeholder="Senha"
                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="icon-lock"></i>
                              </span>
                                </div>
                                <input class="form-control" type="password" name="password_confirmation" placeholder="Repeat password">
                            </div>
                            <button class="btn btn-block btn-success" type="submit">Registrar</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
