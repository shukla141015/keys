@extends('layout.base-template', [
    'title' => 'About | Keys.lol',
    'description' => 'More information about Keys.lol.',
])

@section('content')
    <div class="max-w-md mx-auto">
        <h1 class="mt-4">About</h1>
        <p class="mb-8 leading-normal">
            Keys.lol was inspired by the now defunct directory.io.
            Just like this website, directory.io contained pages of all bitcoin private keys.
            It caused quite the fuss when it was shared on the internet back in 2013 with the title "All Bitcoin private keys leaked".
        </p>

        <h2>2^256</h2>
        <p class="mb-4 leading-normal">
            If you want to try to wrap your head around how many bitcoin private keys there actually are, I can recommended watching this video:
        </p>

        <iframe width="560" height="315" src="https://www.youtube.com/embed/S9JGmA5_unY?rel=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

        <h2 class="mt-8">Generating private keys</h2>
        <p class="mb-8 leading-normal">
            Keys.lol contains all private keys of multiple cryptocurrencies.
            These keys aren't stored on the server, that would take an impossible amount of disk space.
            Instead, the keys are generated whenever a page is opened.
            <br><br>
            The seeds used to generate the private keys are derived from the page number.
            For example, on page 10, the first seed is:
            <code class="block my-2">(10 - 1) * 128 + 0 = 1152</code>
            pages contain 128 keys each, so the last seed on page 10 is:
            <code class="block my-2">(10 - 1) * 128 + 127 = 1279</code>
            This simple formula is repeated for each page, until the maximum seed of 2^256 is reached.
        </p>
    </div>
@endsection
