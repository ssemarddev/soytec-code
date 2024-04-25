@extends('home')

@section('title', 'Iniciar sesión')

@section('css-import')
@parent
@vite(['resources/scss/login.scss', 'resources/css/login.css'])
@endsection

@section('content')
<main class="login-design">
    <div class="waves">
        <img src="{{ asset('src/img/login.png') }}" alt="Iniciar sesión" />
    </div>
    <div class="login">
        <div class="login-data">
            <img class="m-3" style="max-width:100%;" src="{{ asset('src/img/logo.png') }}" alt="" />
            <h1>Inicio de Sesión</h1>
            <form id="login" method="POST" action="login">
                @csrf
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Nombre de usuario">
                    <label for="username"><i class="bi bi-person-badge-fill"></i> Nombre de usuario</label>
                </div>
                <div class="form-floating mb-2">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
                    <label for="password"><i class="bi bi-key-fill"></i> Contraseña</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" name="remember" id="remember">
                    <label class="form-check-label" for="remember">
                        Recordar credenciales
                    </label>
                </div>
                <div class="toast align-items-center text-bg-danger invalid-login
                    @if (count($errors) > 0) show @endif" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            Usuario o contraseña incorrectos
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn-login text-center my-4 w-100"><i class="fa fa-sign-in-alt"></i>
                    Iniciar sesión</button>
            </form>
        </div>
    </div>
</main>
@endsection

@section('scripts')
@parent
@endsection