require('./bootstrap');

window.Vue = require('vue');

Vue.component('bitcoin-page',    require('./components/BitcoinPage.vue'));

const app = new Vue({
    el: '#app'
});
