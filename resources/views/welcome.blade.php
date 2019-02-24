@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-center">
            <h2>Welcome to Latchkey App</h2>
            <h3>Sign in or Register to use application</h3>
        </div>
        <div class="text-center mt-5">
            <h4>
                <a href="{{ url('/login') }}">Login</a>
            </h4>
            <h4>
                <a href="{{ url('/register') }}">Register</a>
            </h4>
        </div>
    </div>
@endsection
