<template>
  <div class="container">
    <div class="row">

      <div class="col-8 offset-2">
        <div class="card" style="width: 100%;">
          <div class="card-header text-center">Cashiers</div>
          <div class="card-body">

            <table class="table table-sm mt-2" v-if="!loading">
              <thead class="thead-light">
              <tr>
                <th scope="col">Cashier name</th>
                <th>Email</th>
              </tr>
              </thead>
              <tbody v-for="item in cashiers" :key="item.id">
              <tr>
                <td><span v-cloak>{{ item.name }}</span></td>
                <td>
                  <span v-cloak>{{ item.email }}</span>
                </td>
              </tr>
              </tbody>
            </table>
            <h5 class="text-center" v-else>Loading...</h5>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script>

  export default {
    name: "CashierComponent",
    data() {
      return {
        loading: false,
        errorMessage: "",
        cashiers: [],
        newCashierName: "",
        showEditModal: false,
        updateID: "",
        updateName: "",
      }
    },
    mounted() {
      console.log("Vue js is running 'cashiers page'...");
      this.getAllCashiers();
    },
    methods: {
      getAllCashiers() {
        this.loading = true;
        axios.get("./api/cashier").then((res) => {
          this.loading = false;
          console.log(res);
          if (res.data.error) {
            this.errorMessage = res.data.message;
          } else {
            this.cashiers = res.data.data;
          }
        });
      },
    },
  }
</script>

<style scoped>

</style>
