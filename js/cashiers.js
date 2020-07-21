new Vue({
  el: "#cashiers",
  data: {
    loading: false,
    errorMessage: "",
    cashiers: [],
    newCashierName: "",
    showEditModal: false,
    updateID: "",
    updateName: "",
  },
  mounted() {
    console.log("Vue js is running 'cashiers page'...");
    this.getAllCashiers();
  },
  methods: {
    getAllCashiers() {
      this.loading = true;
      axios
        .get("/shopping_cart/api/v1.php?action=read-cashiers")
        .then((res) => {
          this.loading = false;
          if (res.data.error) {
            this.errorMessage = res.data.message;
          } else {
            this.cashiers = res.data.cashiers;
          }
        });
    },
    addCashier() {
      var formData = new FormData();
      formData.append("cashier_name", this.newCashierName);
      axios
        .post("/shopping_cart/api/v1.php?action=create-cashier", formData)
        .then((res) => {
          console.log(res);
          this.newCashierName = "";
          this.getAllCashiers();
        });
    },
    deleteCashier(id) {
      console.log(id);
      var formData = new FormData();
      formData.append("id", id);
      axios
        .post("/shopping_cart/api/v1.php?action=delete-cashier", formData)
        .then((res) => {
          console.log(res.data);
          this.getAllCashiers();
        });
    },
    updateCashier() {
      console.log(this.updateID);
      var formData = new FormData();
      formData.append("id", this.updateID);
      formData.append("cashier_name", this.updateName);
      axios
        .post("/shopping_cart/api/v1.php?action=update-cashier", formData)
        .then((res) => {
          console.log(res.data);
          this.showEditModal = false;
          this.getAllCashiers();
        });
    },
    openUpdateModal(id, name) {
      this.updateID = id;
      this.updateName = name;
      this.showEditModal = true;
    },
  },
});
