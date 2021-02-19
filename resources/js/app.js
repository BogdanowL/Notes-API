require('./bootstrap');
window.Vue = require('vue');


import App from "./components/App";
import Notes from "./components/Notes";
import Validation from './components/Validation'

Vue.component('notes', Notes);
Vue.component('validation-errors', Validation);

const app = new Vue({
    el: '#app',
    render: h => h(App)
});
