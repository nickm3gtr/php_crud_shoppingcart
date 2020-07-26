<template>
  <ItemComponent/>
</template>

<script>
  import ItemComponent from "../components/ItemComponent";

  export default {
    name: "Item.vue",
    components: {ItemComponent},
    comments: {
      ItemComponent
    },
    mounted() {
      setTimeout(() => {
        if(!this.$store.state.isAuthenticated) {
          this.$router.push('/login', () => {})
        }
      }, 1000)
    }
  }
</script>

<style scoped>

</style>
