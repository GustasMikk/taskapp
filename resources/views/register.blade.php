@extends('layouts.top')

@section('title', 'Register')

@section('content')
<div>
    <h1>Register</h1>

    <form id="registerForm">
        <input name="name" type="text" placeholder="Username" required>
        <input name="email" type="email" placeholder="Email" required>
        <input name="password" type="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
    
    <p id="message"></p>
    <a href="{{ route('index') }}">Go back</a>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/register.js') }}"></script>
@endsection


