import 'bootstrap/dist/css/bootstrap.min.css';
import './bootstrap';

import { createApp } from "vue";
import { createStore } from 'vuex';

const store = createStore({
  state() {
    return {
      stats: []
    };
  },
  mutations: {
    setSharedData(state, payload) {
      state.stats = payload;
    },
  },
  actions: {
    updateSharedData({ commit }, newData) {
      commit('setSharedData', newData);
    },
  },
});

import App from "./App.vue";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const app = createApp(App)
app.use(VueSweetalert2);
app.use(store);
app.mount('#app');