
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import VueAxios from 'vue-axios';
import iView from 'iview';
import 'iview/dist/styles/iview.css';
import {Tree} from 'element-ui'

Vue.use(iView);
Vue.use(VueAxios, axios);
Vue.use(Tree);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('Login', require('./components/login/login.vue'));
Vue.component('AddOrder', require('./components/order/addorder.vue'));
Vue.component('GoodsCate', require('./components/system/goodscate/index.vue'));
Vue.component('GoodsModel', require('./components/system/goodsmodel/index.vue'));
Vue.component('Bill', require('./components/order/bill.vue'));
Vue.component('List', require('./components/order/orderlist.vue'));


const app = new Vue({
    el: '#app'
});
