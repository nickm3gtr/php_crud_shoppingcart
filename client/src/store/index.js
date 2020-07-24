import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import router from '../router'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    token: localStorage.getItem('token'),
    user: null,
    isAuthenticated: false,
    isError: false,
    errorMessage: '',
  },
  mutations: {
    DEFAULT_STATE: (state) => {
      state.user = null
      state.isAuthenticated = false
      state.isError = false
      state.errorMessage = ''
    },
    SET_TOKEN: (state, payload) => {
      localStorage.setItem('token', payload.access_token);
    },
    AUTH_USER: (state, payload) => {
      state.token = localStorage.getItem('token');
      state.isAuthenticated = true;
      state.user = payload.user;
      state.isError = false;
      state.errorMessage = '';
    },
    LOGOUT_USER: state => {
      localStorage.removeItem('token');
      state.token = null;
      state.user = null;
      state.isAuthenticated = false;
      state.isError = false;
      state.errorMessage = '';
    },
    REGISTER_ERROR: state => {
      state.token = null;
      state.user = null;
      state.isAuthenticated = false;
      state.isError = true;
      state.errorMessage = 'Registration failed';
    },
    LOGIN_ERROR: state => {
      state.token = null;
      state.user = null;
      state.isAuthenticated = false;
      state.isError = true;
      state.errorMessage = 'Login failed';
    }
  },
  actions: {
    registerUser: ({commit}, payload) => {
      const {name, email, password} = payload;
      const config = {
        headers: {
          'Content-Type': 'application/json'
        }
      };
      const newUser = JSON.stringify({
        name, email, password
      });
      axios.post(`./api/cashier`, newUser, config)
        .then((res) => {
          console.log(res);
          commit('DEFAULT_STATE');
          router.push('/login', () => {
          });
        })
        .catch(() => {
          commit('REGISTER_ERROR');
        });
    },
    registerUserError: ({commit}) => {
      commit('REGISTER_ERROR');
    },
    loginUser: ({ commit, dispatch }, payload) => {
      const { username, password } = payload
      const config = {
        headers: {
          'Content-Type': 'application/json'
        }
      }
      const body = JSON.stringify({
        grant_type: 'password',
        client_id: 2,
        client_secret: 'i44FRpoHD56EV7J1d8XNkEXuSVnDdYMHFEM94k8p',
        username,
        password
      })
      axios.post(`./oauth/token`, body, config)
        .then(res => {
          commit('SET_TOKEN', res.data);
          dispatch('authenticateUser');

        })
        .catch(() => {
          commit('LOGIN_ERROR')
        })
    },
    authenticateUser: ({ commit }) => {
      const config = {
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
      }

      axios.get(`./api/user`, config)
        .then(res => {
          const payload = {
            user: res.data
          }
          commit('AUTH_USER', payload)
          router.push('/', () => {})
        })
        .catch(() => {

        })
    },
    logoutUser: ({ commit }) => {
      commit('LOGOUT_USER');
      router.push('/login', () => {})
    }
  },
  modules: {}
})
