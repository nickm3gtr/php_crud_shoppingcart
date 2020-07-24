import Vue from 'vue'
import VueRouter from 'vue-router'

import Item from "../views/Item";
import Cart from "../views/Cart";
import Cashier from "../views/Cashier";
import Login from "../views/Login";
import Register from "../views/Register";
import Transaction from "../views/Transaction";
import store from 'vuex'

Vue.use(VueRouter)

const routes = [
  {
    path: '/login',
    name: 'Login',
    beforeEnter (to, from, next) {
      if(store.isAuthenticated) {
        next('/')
      } else {
        next()
      }
    },
    component: Login
  },
  {
    path: '/register',
    name: 'Register',
    beforeEnter (to, from, next) {
      if(store.isAuthenticated) {
        next('/')
      } else {
        next()
      }
    },
    component: Register
  },
  {
    path: '/',
    name: 'Cart',
    component: Cart
  },
  {
    path: '/items',
    name: 'Item',
    component: Item
  },
  {
    path: '/cashiers',
    name: 'Cashier',
    component: Cashier
  },
  {
    path: '/transactions',
    name: 'Transaction',
    component: Transaction
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
