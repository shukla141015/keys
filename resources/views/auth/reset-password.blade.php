@extends('layout.base-template', [
    'title'       => 'Reset Password',
    'description' => 'SEO description',
])

@section('content')

    <form method="post" class="max-w-xs mx-auto mt-8" action="{{ route('password.request') }}">
        {{ csrf_field() }}

        <input type="hidden" name="token" value="{{ $token }}">

        <label>
            Email address
            <input id="email" type="email" class="field" name="email" value="{{ $email or old('email') }}" required autofocus>
        </label>

        <label>
            Password
            <input id="password" type="password" class="field" name="password" required>
        </label>

        <label>
            Confirm password
            <input id="password-confirm" type="password" class="field" name="password_confirmation" required>
        </label>


        <button type="submit" class="btn block ml-auto">Reset Password</button>

    </form>

@endsection
