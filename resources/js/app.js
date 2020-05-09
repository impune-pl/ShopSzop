/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from "vue";
import VueRouter from "vue-router";
Vue.use(VueRouter);
import JQuery from 'jquery';
Window.$ = JQuery;

import { library } from '@fortawesome/fontawesome-svg-core';
import { faShoppingCart,faTrash, faCashRegister, faCaretDown,faCreditCard,faTruckLoading,faLockOpen,faLock,faHashtag,faDollarSign} from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faCaretDown);
library.add(faShoppingCart);
library.add(faTrash);
library.add(faCashRegister);
library.add(faCreditCard);
library.add(faTruckLoading);
library.add(faLockOpen);
library.add(faLock);
library.add(faHashtag);
library.add(faDollarSign);

Vue.component('font-awesome-icon', FontAwesomeIcon);

import Home from './views/Home';
import Rules from "./views/Rules";
import Orders from "./views/Orders";
import Register from "./views/Register";
import Login from "./views/Login";
import ProductDetails from "./views/ProductDetails";
import Products from "./views/Products";
import App from "./views/App";
import Basket from "./views/Basket";
import Checkout from "./views/Checkout";
import Admin from "./views/Admin";

require('./bootstrap');
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
const routes = [
    {name: 'home', path: '/', component: Home},//ok
    {name: 'products', path: '/products', component: Products},//ok, fix toasts not appearing
    {name: 'product_details', path: '/products/:id', component: ProductDetails},//ok, add toasts
    {name: 'login', path: '/login', component: Login},//ok, fix redirect
    {name: 'register', path: '/register', component: Register},//ok, add confirmation email
    {name: 'basket', path: '/basket', component: Basket, meta:{requiresAuth: true, is_user: true}},//ok
    {name: 'checkout', path: '/checkout', component: Checkout, meta:{requiresAuth: true, is_user: true}},//ok, test for redirect, add error toast
    {name: 'orders', path: '/orders', component: Orders, meta:{requiresAuth: true, is_user: true}},//WIP
    {name: 'rules', path: '/rules', component: Rules},
    {name: 'admin', path: '/admin', component: Admin, meta:{requiresAuth: true, is_admin: true}},
    {name: 'admin_path', path: '/admin/:path', component: Admin, meta:{requiresAuth: true, is_admin: true}}
];

const router = new VueRouter({mode: 'history',routes: routes});

axios.interceptors.request.use(function (config) {
    let token = localStorage.getItem('SzopShop.jwt');
    if (token)
    {
        config.headers['Authorization'] = `Bearer `+token;
    }
    return config;
}, function (error) {
    return Promise.reject(error);
});
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
        }
        else
        {
            let user = JSON.parse(localStorage.getItem('SzopShop.user'));
            if (to.matched.some(record => record.meta.is_admin))
            {
                if (user.isAdmin === true)
                    next();
                else
                    next({ name: 'home' });
            }
            else if (to.matched.some(record => record.meta.is_user))
            {
                if (user.isAdmin === false)
                    next();
                else
                    next({ name: 'admin_orders' });
            }
            next();
        }
    } else
        next();
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
