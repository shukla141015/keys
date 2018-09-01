let mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');
require('laravel-mix-purgecss');

mix.disableNotifications();

mix      .js('resources/assets/js/scripts.js',       'public/js')
         .js('resources/assets/js/bitcoin-page.js',  'public/js')
         .js('resources/assets/js/ethereum-page.js', 'public/js')
    .postCss('resources/assets/pcss/main.pcss', 'public/css', [
        tailwindcss('tailwind.js')
    ])
    .purgeCss()
    .version();
