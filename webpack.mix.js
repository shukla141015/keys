const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
require('laravel-mix-purgecss');

mix.disableNotifications();

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/bitcoin-page.js', 'public/js')
    .js('resources/js/ethereum-page.js', 'public/js')
    .postCss('resources/main.pcss', 'public/css', [
         tailwindcss('tailwind.js')
    ])
    .purgeCss()
    .version();
