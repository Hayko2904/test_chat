@extends('app')
@section('title') Registration
@endsection
@section('content')
    <h2>Registration</h2>
    <form action="{{ route('registration') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input name="name" type="text" class="form-control" id="name" placeholder="name">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input name="email" type="email" class="form-control" id="email" placeholder="name@example.com">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input name="password" type="password" class="form-control" id="email" placeholder="password">
        </div>
        <div class="mb-3">
            <button class="btn btn-success">Registration</button>

            <a class="btn btn-primary" href="{{ route('login') }}">Login page</a>
        </div>
    </form>
@endsection
