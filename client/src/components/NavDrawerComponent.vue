<template>

  <v-navigation-drawer
    app
    :expand-on-hover="true"
    color="grey lighten-3"
  >
    <v-list-item>
      <v-list-item-content>
        <v-list-item-title class="title">

        </v-list-item-title>
        <v-list-item-subtitle>

        </v-list-item-subtitle>
      </v-list-item-content>
    </v-list-item>

    <v-divider></v-divider>

    <v-list
      dense
      nav
    >
      <v-list-item
        v-for="item in items"
        :key="item.title"
        link
        @click="$router.push(item.route).catch(err => {})"
      >
        <v-list-item-icon>
          <v-icon>{{ item.icon }}</v-icon>
        </v-list-item-icon>

        <v-list-item-content>
          <v-list-item-title>{{ item.title }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-list>
  </v-navigation-drawer>

</template>

<script>
  export default {
    name: "NavDrawerComponent",
    data() {
      return {
        items: [
          {title: 'Cart', icon: 'mdi-cart', route: '/'},
          {title: 'Items', icon: 'mdi-shopping', route: '/items'},
          {title: 'Cashiers', icon: 'mdi-account', route: '/cashiers'},
          {title: 'Transactions', icon: 'mdi-cash-usd', route: '/transactions'},
        ],
        right: null,
      }
    },
  }
</script>

<style scoped>

</style>
