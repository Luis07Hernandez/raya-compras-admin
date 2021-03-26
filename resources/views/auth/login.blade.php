@extends('layouts.login_layouts')

@section('content')
    <form class="login-form" action="{{ url('/login') }}" method="post">
        {{ csrf_field() }}

        <h3 class="form-title">Iniciar sesión</h3>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span> Introduce tu correo electrónico y contraseña. </span>
        </div>
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Correo electrónico</label>
            <div class="input-icon">
                <i class="fa fa-envelope"></i>
                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Correo electrónico" name="email" value="{{ old('email') }}" required autofocus />
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label class="control-label visible-ie8 visible-ie9">Contraseña</label>
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Contraseña" name="password" />
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-actions" align="center">
            <button type="submit" class="btn green uppercase"   >Entrar</button>
            {{--<a href="{{ url('/password/reset') }}" id="forget-password" class="forget-password">¿Se te olvidó tu contraseña?</a>--}}
        </div>
        <div class="create-account">
            <p>
                &nbsp;
            </p>
        </div>
    </form>
@endsection