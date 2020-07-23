<template>
  <div class="container">
    <div class="row">

      <div class="col-4">
        <div class="card">
          <div class="card-header text-center">
            Add Item to Cart
          </div>
          <div class="card-body">
            <div class="form-group">
              <label>Select item</label>
              <select class="form-control" v-model="selected_item">
                <option v-for="item in items" :value="{id: item.id, name: item.item_name, price: item.item_price}">
                  <span v-cloak>{{ item.item_name }}</span>
                </option>
              </select>
            </div>
            <div class="form-group">
              <label>Item Quantity</label>
              <input v-model="item_quantity" type="text" class="form-control">
            </div>
            <div class="text-center">
              <button @click="addToCart()" type="button" class="btn btn-primary mb-2">Add to cart</button>
            </div>
          </div>
        </div>
      </div>

      <div class="col-8">
        <div class="card">
          <div class="card-header text-center">
            Shopping Cart
          </div>
          <div class="card-body">
            <div class="form-group">
              <label>Select cashier</label>
              <select class="form-control" v-model="selected_cashier">
                <option v-for="cashier in cashiers" :value="cashier.id">
                  <span v-cloak>{{ cashier.name }}</span>
                </option>
              </select>
            </div>
            <!-- Table for cart -->
            <table class="table table-sm mt-2" v-if="!loading && items.length > 0">
              <thead class="thead-light">
              <tr>
                <th scope="col">Item name</th>
                <th scope="col">Item price</th>
                <th scope="col">Item quantity</th>
                <th scope="col">Amount</th>
              </tr>
              </thead>
              <tbody v-for="(item, index) in cart" :key="index">
              <tr>
                <td><span v-cloak>{{ item.item_name }}</span></td>
                <td><span v-cloak>{{ item.item_price }}</span></td>
                <td><span v-cloak>{{ item.item_qty }}</span></td>
                <td><span v-cloak>{{ item.item_amount }}</span></td>
              </tr>
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <p v-cloak>Total Amount: {{ totalAmount }}</p>
            <button @click="submitCart()" class="btn btn-primary" type="button">Submit</button>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
  export default {
    name: "CartComponent.vue",
    data() {
      return {
        loading: false,
        errorMessage: "",
        selected_item: {id: "", name: "", price: ""},
        selected_cashier: "",
        items: [],
        cashiers: [],
        item_quantity: 1,
        cartId: "",
        cart: [],
      }
    },
    mounted() {
      console.log("Vue js is running 'cart page'...");
      this.getAllItems();
      this.getAllCashiers();
    },
    methods: {
      getAllItems() {
        this.loading = true;
        axios.get("./api/item").then((res) => {
          console.log(res.data.data);
          this.loading = false;
          if (res.data.error) {
            this.errorMessage = res.data.message;
          } else {
            this.items = res.data.data;
          }
        });
      },
      getAllCashiers() {
        this.loading = true;
        axios.get("./api/cashier").then((res) => {
          console.log(res.data.cashiers);
          this.loading = false;
          if (res.data.error) {
            this.errorMessage = res.data.message;
          } else {
            this.cashiers = res.data.data;
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
        this.selected_item = {id: "", name: "", price: ""};
        this.item_quantity = 1;
      },
      submitCart() {
        let date = new Date().toISOString().slice(0, 19).replace('T', ' ');
        let formData = new FormData();
        formData.append("cashier_id", this.selected_cashier);
        formData.append("date_time", date);
        // Post cart
        axios.post("./api/cart", formData).then((res) => {
          console.log(res.data);
          // GET CART ID
          axios.get("./api/cart").then((res) => {
            console.log("ID latest", res.data.data.id);
            // Post to Item_Cart
            //Must loop all cart contents
            for (let i = 0; i < this.cart.length; i++) {
              let formData = new FormData();
              formData.append("item_id", this.cart[i].item_id);
              formData.append("cart_id", res.data.data.id);
              formData.append("item_qty", this.cart[i].item_qty);
              axios
                .post("./api/item_cart", formData)
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
  }
</script>

<style scoped>

</style>