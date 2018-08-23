require('./bootstrap');

window.Vue = require('vue');

Vue.productionTip = false;

Vue.component('bitcoin-page', require('./components/BitcoinPage.vue'));

const app = new Vue({
    el: '#app'
});
