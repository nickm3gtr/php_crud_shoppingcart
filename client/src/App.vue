<template>
  <v-app>
    <v-app-bar
      app dense
      color="grey lighten-2"

    >
      <v-toolbar-title>Shopping Cart</v-toolbar-title>

      <v-spacer></v-spacer>

      <v-toolbar-items v-if="!isAuthenticated">
        <v-btn text class="font-weight-light" @click="$router.push('/login', () => {})">Login</v-btn>
        <v-btn text class="font-weight-light" @click="$router.push('/register', () => {})">Register</v-btn>
      </v-toolbar-items>

      <v-toolbar-items v-else>
        <v-btn text class="font-weight-light" @click="logout">Logout</v-btn>
      </v-toolbar-items>

    </v-app-bar>

    <NavDrawerComponent v-if="isAuthenticated" />

    <v-main class="view-container">
      <router-view></router-view>
    </v-main>

  </v-app>
</template>

<script>
  import NavDrawerComponent from "./components/NavDrawerComponent";
  import { mapState } from 'vuex'

  export default {
    name: 'App',
    components: {
      NavDrawerComponent
    },

    data: () => ({

    }),
    beforeCreate() {
      this.$store.dispatch('authenticateUser');
    },
    methods: {
      logout() {
        this.$store.dispatch('logoutUser');
      }
    },
    computed: {
      ...mapState(['isAuthenticated'])
    }
  };
</script>

<style>
  .view-container {
    background-color: #f4f3ef;
  }
</style>
