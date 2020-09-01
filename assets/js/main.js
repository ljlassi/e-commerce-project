import Vue from 'vue';
import axios from 'axios'
import VueAxios from 'vue-axios'
import Home from './components/Home'
import ListProducts from "./components/ListProducts";
import ShoppingCart from "./components/ShoppingCart";

Vue.use(VueAxios, axios)
new Vue({
    el: '#app', // where <div id="app"> in your DOM contains the Vue template
    components: {
        'home' : Home,
        'list-products' : ListProducts,
        'shopping-cart' : ShoppingCart
    }
});
