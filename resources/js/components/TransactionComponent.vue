<template>
  <div class="container">
    <div class="row">

      <div class="col-6">
        <div class="card">
          <div class="card-header text-center">Transactions</div>
          <div class="card-body">
            <table class="table table-sm mt-2" v-if="!loading">
              <thead class="thead-light">
              <tr>
                <th>Cart ID</th>
                <th scope="col">Cashier</th>
                <th scope="col">Date</th>
                <th></th>
              </tr>
              </thead>
              <tbody v-for="(item, index) in transactions" :key="index">
              <tr>
                <td><span v-cloak>{{ item.id }}</span></td>
                <td><span v-cloak>{{ item.name }}</span></td>
                <td><span v-cloak>{{ item.date_time }}</span></td>
                <td>
                  <button @click="viewDetails(item.id)" class="btn btn-primary btn-sm">details</button>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-6">
        <div class="card">
          <div class="card-header text-center">Transaction Detail:</div>
          <div class="card-body">
            <p>Cashier name: <span v-cloak>{{ cashierName }}</span></p>
            <p>Date: <span v-cloak>{{ date }}</span></p>
            <table class="table table-sm mt-2" v-if="!loading">
              <thead class="thead-light">
              <tr>
                <th>Item name</th>
                <th scope="col">Price</th>
                <th scope="col">Qty</th>
                <th scope="col">Amount</th>
              </tr>
              </thead>
              <tbody v-for="(item, index) in transactionDetails" :key="index">
              <tr>
                <td><span v-cloak>{{ item.item_name }}</span></td>
                <td><span v-cloak>{{ item.item_price }}</span></td>
                <td><span v-cloak>{{ item.item_qty }}</span></td>
                <td><span v-cloak>{{ parseFloat(item.item_qty * item.item_price).toFixed(2) }}</span></td>
              </tr>
              </tbody>
            </table>
            <p>Total Amount: <span v-cloak>{{ totalAmount }}</span></p>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
  export default {
    name: "TransactionComponent",
    data() {
      return {
        loading: false,
        errorMessage: "",
        transactions: [],
        transactionDetails: [],
        date: "",
        cashierName: "",
      }
    },
    mounted() {
      console.log("Vue js is running 'transactions page'...");
      this.getAllTransactions();
    },
    methods: {
      getAllTransactions() {
        this.loading = true;
        axios.get("./api/transaction").then((res) => {
          console.log(res);
          this.loading = false;
          if (res.data.error) {
            this.errorMessage = res.data.message;
          } else {
            this.transactions = res.data.data;
          }
        });
      },
      viewDetails(id) {
        console.log(id);
        axios
          .get(`./api/transaction/${id}`)
          .then((res) => {
            console.log(res);
            this.cashierName = res.data.data[0].name;
            this.date = res.data.data[0].date_time;
            this.transactionDetails = res.data.data;
          });
      },
    },
    computed: {
      totalAmount() {
        let amount = this.transactionDetails.map((item) => {
          let amount = parseFloat(item.item_price * item.item_qty);
          return amount;
        });
        const sumTotal = (amount) => amount.reduce((a, b) => a + b, 0);
        const sum = sumTotal(amount);
        return parseFloat(sum).toFixed(2);
      },
    },
  }
</script>

<style scoped>

</style>