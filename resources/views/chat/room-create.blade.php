@extends('app')
@section('title') Registration
@endsection
@section('content')
    <h2>Create chat room</h2>
    <form action="{{ route('chat-room-store') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input name="name" type="text" class="form-control" id="name" placeholder="name">
        </div>
        <div class="mb-3">
            <button class="btn btn-success">Create</button>
        </div>
    </form>
@endsection
