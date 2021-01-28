require('./bootstrap');

window.Vue = require('vue');

/* EventBus - Biblioteca para la comunicación entre componentes */
export const EventBus = new Vue();
window.EventBus = EventBus;


/* Vuesax - Biblioteca para interfaz de usuario */
import Vuesax from 'vuesax';
import 'vuesax/dist/vuesax.css';
Vue.use(Vuesax, {
    // options here
});


/* SweetAlert2 - Biblioteca para ventanas emergentes */
import Swal from 'sweetalert2';
window.Swal = Swal;



Vue.component('App', require('./components/App').default);


import router from './routes.js'
const app = new Vue({
    el: '#app',
    router
});