/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from "vue";
import VueRouter from "vue-router";
Vue.use(VueRouter);

import { library } from '@fortawesome/fontawesome-svg-core';
import { faUserSecret } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

library.add(faUserSecret);

Vue.component('font-awesome-icon', FontAwesomeIcon);

import Home from './views/Home';
import OrderDetails from "./views/OrderDetails";
import Users from "./views/Users";
import Rules from "./views/Rules";
import Orders from "./views/Orders";
import Register from "./views/Register";
import Login from "./views/Login";
import ProductDetails from "./views/ProductDetails";
import Products from "./views/Products";
import Dashboard from "./views/Dashboard";
import Admin from "./views/Admin";
import App from "./views/App";

require('./bootstrap');
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
const routes = [
    {name: 'home', path: '/', component: Home},
    {name: 'products', path: '/products', component: Products},
    {name: 'product_details', path: '/products/:id', component: ProductDetails},
    {name: 'login', path: '/login', component: Login},
    {name: 'register', path: '/register', component: Register},
    {name: 'orders', path: '/orders', component: Orders, meta:{requiresAuth: true, is_user: true}},
    {name: 'order_details', path: '/orders/{id}', component: OrderDetails, meta:{requiresAuth: true, is_user: true}},
    {name: 'users', path: '/users', component: Users, meta:{requiresAuth: true, is_admin: true}},
    {name: 'rules', path: '/rules', component: Rules},
    {name: 'dashboard', path: '/dashboard', component: Dashboard, meta:{requiresAuth: true, is_user: true}},
    {name: 'admin', path: '/admin', component:  Admin, meta:{requiresAuth: true, is_admin: true}},
    {name: 'admin_page', path: '/admin/{page}', Admin, meta:{requiresAuth: true, is_admin: true}}
];

const router = new VueRouter({mode: 'history',routes: routes});
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth))
    {
        if (localStorage.getItem('SzopShop.jwt') == null)
        {
            next({
                path: '/login',
                params: { nextUrl: to.fullPath }
            });
        } else
        {
            let user = JSON.parse(localStorage.getItem('SzopShop.user'))
            if (to.matched.some(record => record.meta.is_admin) && user.is_admin === false)
                next({ name: 'dashboard' });
            else if (to.matched.some(record => record.meta.is_user) && user.is_admin === true)
                next({ name: 'admin' });
        }
    } else
        next()
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
