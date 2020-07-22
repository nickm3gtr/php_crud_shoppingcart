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
      axios.get("./api/v2/cashier/read.php").then((res) => {
        this.loading = false;
        console.log(res);
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
      axios.post("./api/v2/cashier/create.php", formData).then((res) => {
        console.log(res);
        this.newCashierName = "";
        this.getAllCashiers();
      });
    },
    deleteCashier(id) {
      console.log(id);
      let formData = new FormData();
      formData.append("id", id);
      axios.post("./api/v1.php?action=delete-cashier", formData).then((res) => {
        console.log(res.data);
        this.getAllCashiers();
      });
    },
    updateCashier() {
      console.log(this.updateID);
      let formData = new FormData();
      formData.append("id", this.updateID);
      formData.append("cashier_name", this.updateName);
      axios.post("./api/v2/cashier/update.php", formData).then((res) => {
        console.log(res);
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
