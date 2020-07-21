new Vue({
  el: "#transactions",
  data: {
    loading: false,
    errorMessage: "",
    transactions: [],
    transactionDetails: [],
    date: "",
    cashierName: "",
  },
  mounted() {
    console.log("Vue js is running 'transactions page'...");
    this.getAllTransactions();
  },
  methods: {
    getAllTransactions() {
      this.loading = true;
      axios
        .get(
          "http://localhost:/shopping_cart/api/v1.php?action=read-transactions"
        )
        .then((res) => {
          console.log(res.data.transactions);
          this.loading = false;
          if (res.data.error) {
            this.errorMessage = res.data.message;
          } else {
            this.transactions = res.data.transactions;
          }
        });
    },
    viewDetails(id) {
      console.log(id);
      var formData = new FormData();
      formData.append("cart_id", id);
      axios
        .post(
          "http://localhost:/shopping_cart/api/v1.php?action=read-transaction-details",
          formData
        )
        .then((res) => {
          this.cashierName = res.data.transaction_details[0].cashier_name;
          this.date = res.data.transaction_details[0].date_time;
          this.transactionDetails = res.data.transaction_details;
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
});
