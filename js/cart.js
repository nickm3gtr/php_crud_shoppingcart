new Vue({
  el: "#cart",
  data: {
    loading: false,
    errorMessage: "",
    selected_item: { id: "", name: "", price: "" },
    selected_cashier: "",
    items: [],
    cashiers: [],
    item_quantity: 1,
    cartId: "",
    cart: [],
  },
  mounted() {
    console.log("Vue js is running 'cart page'...");
    this.getAllItems();
    this.getAllCashiers();
    // axios
    //   .get("http://localhost:/shopping_cart/api/v1.php?action=get-latest-id")
    //   .then((res) => {
    //     console.log(res.data);
    //     if (res.data === 0) {
    //       this.cartId = 1;
    //     } else {
    //       this.cartId = res.data.id.id;
    //     }
    //   });
  },
  methods: {
    getAllItems() {
      this.loading = true;
      axios.get("./api/v2/item/read.php").then((res) => {
        console.log(res.data.items);
        this.loading = false;
        if (res.data.error) {
          this.errorMessage = res.data.message;
        } else {
          this.items = res.data.items;
        }
      });
    },
    getAllCashiers() {
      this.loading = true;
      axios.get("./api/v2/cashier/read.php").then((res) => {
        console.log(res.data.cashiers);
        this.loading = false;
        if (res.data.error) {
          this.errorMessage = res.data.message;
        } else {
          this.cashiers = res.data.cashiers;
        }
      });
    },
    addToCart() {
      this.cart.push({
        item_id: this.selected_item.id,
        item_name: this.selected_item.name,
        item_price: this.selected_item.price,
        item_qty: this.item_quantity,
        item_amount: parseFloat(
          this.item_quantity * this.selected_item.price
        ).toFixed(2),
      });
      this.selected_item = { id: "", name: "", price: "" };
      this.item_quantity = 1;
    },
    submitCart() {
      var formData = new FormData();
      formData.append("cashier_id", this.selected_cashier);
      // Post cart
      axios.post("./api/v2/cart/create.php", formData).then((res) => {
        console.log(res.data);
        // GET CART ID
        axios.get("./api/v2/cart/show.php").then((res) => {
          console.log("ID latest", res.data.id[0]);
          // Post to Item_Cart
          //Must loop all cart contents
          for (let i = 0; i < this.cart.length; i++) {
            // console.log(this.cart[i].item_name);
            let formData = new FormData();
            formData.append("item_id", this.cart[i].item_id);
            formData.append("cart_id", res.data.id[0]);
            formData.append("item_qty", this.cart[i].item_qty);
            axios
              .post("./api/v2/item_cart/create.php", formData)
              .then((res) => {
                console.log(res.data);
                this.cart = [];
              });
            // console.log(this.cart[i].item_id + "," + res.data.id[0]);
          }
        });
      });
    },
  },
  computed: {
    totalAmount() {
      let amount = this.cart.map((item) => {
        return parseFloat(item.item_amount);
      });
      const sumTotal = (amount) => amount.reduce((a, b) => a + b, 0);
      const sum = sumTotal(amount);
      return parseFloat(sum).toFixed(2);
    },
  },
});
