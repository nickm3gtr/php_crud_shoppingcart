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
      axios.get("./api/v2/item/read.php").then((res) => {
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
      let formData = new FormData();
      formData.append("item_name", this.newItemName);
      formData.append("item_price", this.newItemPrice);
      axios.post("./api/v2/item/create.php", formData).then((res) => {
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
      axios.post("./api/v2/item/delete.php", formData).then((res) => {
        console.log(res);
        this.getAllItems();
      });
    },
    updateItem() {
      console.log(this.updateID);
      let formData = new FormData();
      formData.append("id", this.updateID);
      formData.append("item_name", this.updateName);
      formData.append("item_price", this.updatePrice);
      axios.post("./api/v2/item/update.php", formData).then((res) => {
        console.log(res);
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
