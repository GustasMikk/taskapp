@extends('layouts.top')

@section('title', 'Login')

@section('content')
<div>
    <h1>Login</h1>

    <form id="loginForm">
        @csrf
        <input type="text" name="name" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <p id="message"></p>
    <p>
        Don’t have an account? <a href="{{ route('register') }}">Register here</a>
    </p>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/index.js') }}"></script>
@endsection
