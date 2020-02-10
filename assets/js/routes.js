import VueRouter from "vue-router";
import {loadPage} from "./helpers";
import Vue from "vue";
import store from "./store";

Vue.use(VueRouter);

let router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: '/',
            component: loadPage('form'),
            meta: {
                title: 'Subscribe'
            }
        },
        {
            path: '/login',
            component: loadPage('login'),
            meta: {
                title: 'Login',
            }
        },
        {
            path: '/admin',
            component: loadPage('admin'),
            meta: {
                title: 'Admin',
                requiresAuth: true
            }
        },
        {
            path: "*",
            component: loadPage('404'),
            meta: {
                title: 'Page not found'
            }
        }
    ],
});

router.beforeResolve((to, from, next) => {
    if (to.meta.requiresAuth) {
      next('/login');
      return;
    }
    store.commit('startLoading');
    setTimeout(function () {
        next();
    }, 250);
});

router.afterEach((to, from) => {
    store.commit('stopLoading');
});

export default router;