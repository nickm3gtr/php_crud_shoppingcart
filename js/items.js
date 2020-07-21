new Vue({
  el: "#items",
  data: {
    loading: false,
    errorMessage: "",
    items: [],
    newItemName: "",
    newItemPrice: "",
    showEditModal: false,
    updateID: "",
    updateName: "",
    updatePrice: "",
  },
  mounted() {
    console.log("Vue js is running 'items page'...");
    this.getAllItems();
  },
  methods: {
    getAllItems() {
      this.loading = true;
      axios.get("./api/v1.php?action=read-items").then((res) => {
        console.log(res);
        this.loading = false;
        if (res.data.error) {
          this.errorMessage = res.data.message;
        } else {
          this.items = res.data.items;
        }
      });
    },
    addItem() {
      newItem = {
        item_name: this.newItemName,
        item_price: this.newItemPrice,
      };
      var formData = new FormData();
      formData.append("item_name", this.newItemName);
      formData.append("item_price", this.newItemPrice);
      axios.post("./api/v1.php?action=create-item", formData).then((res) => {
        console.log(res);
        this.newItemName = "";
        this.newItemPrice = "";
        this.getAllItems();
      });
    },
    deleteItem(id) {
      console.log(id);
      var formData = new FormData();
      formData.append("id", id);
      axios.post("./api/v1.php?action=delete-item", formData).then((res) => {
        console.log(res.data);
        this.getAllItems();
      });
    },
    updateItem() {
      console.log(this.updateID);
      var formData = new FormData();
      formData.append("id", this.updateID);
      formData.append("item_name", this.updateName);
      formData.append("item_price", this.updatePrice);
      axios.post("./api/v1.php?action=update-item", formData).then((res) => {
        console.log(res.data);
        this.showEditModal = false;
        this.getAllItems();
      });
    },
    openUpdateModal(id, name, price) {
      this.updateID = id;
      this.updateName = name;
      this.updatePrice = price;
      this.showEditModal = true;
    },
  },
});
