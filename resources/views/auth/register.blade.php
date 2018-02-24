@extends('layout.base-template', [
    'title'       => 'Register',
    'description' => 'SEO description',
])

@section('content')

    <form class="max-w-xs bg-white border mx-auto p-2" method="post" action="{{ route('register') }}">
        <h2 class="mb-4">Register</h2>
        {{ csrf_field() }}

        <label>
            Email
            <input class="field" type="email" name="email" value="{{ old('email') }}" required autofocus>
        </label>

        <label>
            Password
            <input class="field" type="password" name="password" required>
        </label>

        <label>
            Repeat password
            <input class="field" type="password" name="password_confirmation" required>
        </label>

        <button type="submit" class="btn block ml-auto mt-4">Registeren</button>
    </form>

@endsection
