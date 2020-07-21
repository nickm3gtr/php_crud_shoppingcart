new Vue({
  el: "#app",
  data: {
    errorMessage: "",
    items: [],
  },
  mounted() {
    console.log("Vue js is running...");
    this.getAllItems();
  },
  methods: {
    getAllItems() {
      axios
        .get("http://localhost:/shopping_cart/api/v1.php?action=read-items")
        .then((res) => {
          console.log(res);

          if (res.data.error) {
            this.errorMessage = res.data.message;
          } else {
            this.items = res.data.items;
          }
        });
    },
  },
});
