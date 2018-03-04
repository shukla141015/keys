// IE11 needs a promise polyfill
require('es6-promise').polyfill();

window._ = require('lodash');

try {
    window.$ = window.jQuery = require('jquery');
} catch (e) {}

window.axios = require('axios');


// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
//
//
// let token = document.head.querySelector('meta[name="csrf-token"]');
//
// if (token) {
//     window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
// } else {
//     console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
// }


// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: Laravel.pusherKey, // since 5.6: process.env.MIX_PUSHER_APP_KEY
//     cluster: Laravel.pusherCluster, // since 5.6: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: Laravel.pusherEncrypted,
// });

window.bitcoin = require('bitcoinjs-lib');

window.randomBytes = require('random-bytes');

window.bigi = require('bigi');
