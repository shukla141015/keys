<footer class="py-2 mt-4 bg-white border-t text-xs">
    <div class="flex justify-around text-center max-w-md mx-auto">
        <a class="text-black hover:underline" href="{{ route('about') }}">About</a>

        <a class="text-black hover:underline" href="{{ route('stats') }}">Statistics</a>

        <a class="flex text-black hover:underline" href="https://github.com/SjorsO/keys">
            <span class="h-4 w-4 mr-1">@include('components.svg.github')</span>
            Github
        </a>
    </div>
</footer>
