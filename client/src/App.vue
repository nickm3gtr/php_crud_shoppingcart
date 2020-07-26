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

      <v-toolbar-items v-if="isAuthenticated">

        <v-menu
          v-model="menu"
          :open-on-click="true"
          :close-on-click="true"
          :close-on-content-click="true"
          :offset-y="true"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              fab
              text
              class="font-weight-light"
              v-bind="attrs"
              v-on="on"
              :value="user.name"
            >
              <v-icon>mdi-account-circle-outline</v-icon>
            </v-btn>
          </template>
          <v-list>
            <v-list-item
            >
              <v-list-item-title>{{ this.user.name }}</v-list-item-title>
            </v-list-item>
            <v-list-item
              @click="logout"
            >
              <v-list-item-title>Logout</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
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
      menu: false,
    }),
    beforeCreate() {
      this.$store.dispatch('authenticateUser');
    },
    methods: {
      logout() {
        this.$store.dispatch('logoutUser');
        this.menu = false
      }
    },
    computed: {
      ...mapState(['isAuthenticated', 'user'])
    }
  };
</script>

<style>
  .view-container {
    background-color: #f4f3ef;
  }
</style>
