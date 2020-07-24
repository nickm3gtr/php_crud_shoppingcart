import Vue from 'vue'
import VueRouter from 'vue-router'

import Item from "../views/Item";
import Cart from "../views/Cart";
import Cashier from "../views/Cashier";

Vue.use(VueRouter)

const routes = [
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
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
