import Vue from 'vue';
import axios from 'axios'
import VueAxios from 'vue-axios'
import Example from './components/Example'
import Home from './components/Home'
import ListProducts from "./components/ListProducts";

Vue.use(VueAxios, axios)
new Vue({
    el: '#app', // where <div id="app"> in your DOM contains the Vue template
    components: {
        'example' : Example,
        'home' : Home,
        'list-products' : ListProducts
    }
});
