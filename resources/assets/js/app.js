
require('./bootstrap');
window.Vue = require('vue');

import Vue from 'vue'
import VueRouter from 'vue-router'
import Snotify from 'vue-snotify'
import 'vue-snotify/styles/material.css'
import Element from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import locale from 'element-ui/lib/locale/lang/en'

Vue.use(Element, {
    locale
})
Vue.use(VueRouter) 
Vue.use(Snotify)

Vue.component('example-component', require('./components/ExampleComponent.vue'));
let Viewdtr = require('./components/Viewdtr.vue');
let Filterdtr = require('./components/Filterdtr.vue');
let Filterdtrao = require('./components/Filterdtrao.vue');
import ChangePassword from './../js/components/ChangePassword.vue' 


// const routes = [
//   { path: '/my-dtr', component: ViewDtr },
// ]

// const router = new VueRouter({ 
// 	//mode: 'history',
//   routes,

// })

const app = new Vue({
    el: '#app',
   // router,
   components: {Viewdtr, Filterdtr, Filterdtrao, ChangePassword}
});
