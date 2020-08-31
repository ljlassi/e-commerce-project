import Vue from 'vue';
//import axios from 'axios'
//import VueAxios from 'vue-axios'
import Example from './components/Example'

new Vue({
    el: '#app', // where <div id="app"> in your DOM contains the Vue template
    components: {Example},
    delimiters: ['${', '}$']
});
