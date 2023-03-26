@extends('app')
@section('title') Login
@endsection
@section('content')
    <h2>Login</h2>
    <form action="{{ route('auth') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input name="email" type="email" class="form-control" id="email" placeholder="name@example.com">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input name="password" type="password" class="form-control" id="email" placeholder="password">
        </div>
        <div class="mb-3">
            <button class="btn btn-success">Login</button>

            <a class="btn btn-primary" href="{{ route('registration-page') }}">Registration page</a>
        </div>
    </form>
@endsection
