<template>
  <div>
    <CashierComponent />
  </div>
</template>

<script>
  import CashierComponent from "../components/CashierComponent";

  export default {
    name: "Cashier",
    components: {
      CashierComponent
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
