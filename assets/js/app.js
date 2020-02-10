import '../scss/app.scss';
import 'typeface-roboto';

import Vue from 'vue';
import VueMaterial from 'vue-material';

import router from "./routes";
import store from "./store";

Vue.use(VueMaterial);

const app = new Vue({
    el: '#app',
    router,
    store,
});