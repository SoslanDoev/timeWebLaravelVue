import { createStore } from 'vuex';
import axios from "axios"

const store = createStore({
  state: {
    showPreloader: false,
    userLoaded: false,
    user: null,
    auth: localStorage.getItem('access_token') || null,
    tests: null,
  },
  getters: {
    userLoaded(state) {
      return state.userLoaded;
    },
    user: state => {
      return state.user
    },
  },
  mutations: {
    setTests(state, payload) {
      state.tests = payload
    },
    setShowPreloader(state, payload) {
      state.showPreloader = payload
    },
    userLoaded(state, payload) {
      state.userLoaded = payload;
    },
    setUser(state, payload) {
      state.user = payload;
    },
    setAuth(state, payload) {
      console.log("yes")
      state.auth = payload
    }
  },
  actions: {
    async loginEmailPassword({ state, commit }, credentials) { // Проверки логина и пароля
      console.log(credentials.email, credentials.password)
    },
    async login({ state, commit }, credentials) { // Функция автоматического входа
      try {
        if (!state.auth) {
          commit('userLoaded', true);
          throw new Error("LocalStorage пустой");
        }
        const response = await axios.post("/api/auth/me", {}, {
          headers: { "Authorization": `Bearer ${state.auth}` }
        });
        console.log("login", response)
        console.log("response", response)
        if (response.data) {
          const user = response.data;
          console.log("user123", user)
          commit('userLoaded', true);
          commit('setUser', user);
        } else {
          commit('userLoaded', true);
          commit('setUser', null);
        }
      } catch(err) {
        commit('userLoaded', true);
        commit('setUser', null);
        throw err;
      }
    },
    async logout({ state, commit }, credentials) { // Функция выхода
      try {
        const response = await axios.post("/api/auth/logout", {}, {
          headers: {
            "Authorization": `Bearer ${state.auth}`
          }
        });
        console.log(response)
        localStorage.removeItem("access_token")
        // commit('userLoaded', false);
        commit('setUser', null);
        commit('setAuth', null);
      } catch(err) {
        throw err;
      }
    }
  },
  modules: {
    // Ваши модули
  },
});

export default store;