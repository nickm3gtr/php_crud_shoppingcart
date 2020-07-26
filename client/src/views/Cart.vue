<template>
  <div>
    <CartComponent/>
  </div>
</template>

<script>
  import CartComponent from "../components/CartComponent";

  export default {
    name: "Cart",
    components: {CartComponent},
    comments: {
      CartComponent
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
