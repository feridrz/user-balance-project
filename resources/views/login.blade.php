@extends('layouts.main')

@section('title', 'Вход')

@section('content')
    <body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-sm p-4" style="min-width: 380px;">
        <h2 class="mb-4 text-center">Вход в систему</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf
            <div class="mb-3">
                <label for="login" class="form-label">Логин</label>
                <input type="text" class="form-control" id="login" name="login" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Войти</button>
        </form>
    </div>
    </body>
@endsection
