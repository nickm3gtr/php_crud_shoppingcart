<template>
  <TransactionComponent />
</template>

<script>
  import TransactionComponent from "../components/TransactionComponent";
  export default {
    name: "Transaction",
    components: {TransactionComponent},
    comments: {
      TransactionComponent
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