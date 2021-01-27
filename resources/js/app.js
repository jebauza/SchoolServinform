require('./bootstrap');

window.Vue = require('vue');



Vue.component('App', require('./components/App').default);


const app = new Vue({
    el: '#app',
});