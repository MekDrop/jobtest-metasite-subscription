import Vuex from 'vuex';
import Vue from "vue";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        isLoading: false
    },
    getters: {
        possibleCategories: () => document
            .querySelector('meta[name="data-categories"]')
            .getAttribute('content')
            .split(',')
    },
    mutations: {
        startLoading(state) {
            state.isLoading = true;
        },
        stopLoading(state) {
            state.isLoading = false;
        },
    },
});