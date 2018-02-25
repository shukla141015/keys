require('./bootstrap');

window.Vue = require('vue');

Vue.component('bitcoin-lottery', require('./components/BitcoinLottery.vue'));

const app = new Vue({
    el: '#app'
});
