<template>
  <v-app>
    <v-app-bar
      app dense
      color="grey lighten-2"

    >
      <v-toolbar-title>Shopping Cart</v-toolbar-title>

      <v-spacer></v-spacer>

    </v-app-bar>

    <NavDrawerComponent />

    <v-main class="view-container">
      <router-view></router-view>
    </v-main>

  </v-app>
</template>

<script>
  import NavDrawerComponent from "./components/NavDrawerComponent";

  export default {
    name: 'App',
    components: {
      NavDrawerComponent
    },

    data: () => ({

    }),
    methods: {

    }
  };
</script>

<style>
  .view-container {
    background-color: #f4f3ef;
  }
</style>
