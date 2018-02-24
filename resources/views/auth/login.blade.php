@extends('layout.base-template', [
    'title'       => 'Login',
    'description' => 'SEO description',
])

@section('content')

    <form class="max-w-xs bg-white border mx-auto p-2" method="post" action="{{ route('login') }}">
        <h2 class="mb-4">Login</h2>
        {{ csrf_field() }}

        <label>
            Email
            <input class="field" type="email" name="email" value="{{ old('email') }}" required autofocus>
        </label>

        <label>
            Wachtwoord
            <input class="field" type="password" name="password" required>
        </label>

        <label class="block mb-3 cursor-pointer">
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
        </label>

        <button type="submit" class="btn block ml-auto">Login</button>
    </form>

    <div class="max-w-xs flex justify-between mx-auto px-1 mt-4">
        <a class="text-sm text-grey" href="{{ route('password.request') }}">Forgot password?</a>

        <a class="text-sm text-grey" href="{{ route('register') }}">No account yet?</a>
    </div>

@endsection
