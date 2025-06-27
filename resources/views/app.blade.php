@extends('layouts.main')

@section('title', 'Баланс пользователя')

@section('content')
    <div id="app" class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4 mb-4">
                    <dashboard></dashboard>
                </div>
                <div class="col-md-8 mb-4">
                    <transaction-history></transaction-history>
                </div>
            </div>

            <form action="/logout" method="POST" class="mt-3 text-center">
                @csrf
                <button type="submit" class="btn btn-secondary">Выйти</button>
            </form>
        </div>
    </div>
@endsection
