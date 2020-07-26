<template>
  <div class="cart">
    <v-layout>
      <v-flex md4>
        <v-card outlined class="my-6 ml-4 pa-4">
          <v-card-title>
            <span class="subtitle-1 font-weight-light">Add item to cart</span>
          </v-card-title>
          <v-card-text>

            <v-col class="d-flex" cols="12" sm="12">
              <v-select
                v-model="selected_item"
                :items="items"
                label="Select item"
                outlined
                dense
                item-text="item_name"
                return-object
              ></v-select>
            </v-col>

            <v-col class="d-flex" cols="12" sm="12">
              <v-text-field
                v-model="item_qty"
                label="Item quantity"
                dense
                outlined
              ></v-text-field>
            </v-col>

          </v-card-text>
          <v-card-actions class="justify-center">
            <v-btn color="primary" @click="addToCart">Add to Cart</v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
      <v-flex md8>
        <v-card outlined class="my-6 mx-4 mr-8 pa-4">
          <v-card-title>
            <span class="subtitle-1 font-weight-light">Shopping Cart</span>
          </v-card-title>
          <v-card-text>

            <span class="subtitle-2">Cashier name: <span v-if="$store.state.user">{{ $store.state.user.name }}</span></span>
            <v-data-table
              class="elevation-3"
              dense
              :headers="headers"
              :items="cart"
            ></v-data-table>
            <v-row>
              <span class="subtitle-2 mt-3">Total amount: {{this.totalAmount}}</span>
            </v-row>
          </v-card-text>
          <v-card-actions class="justify-center">
            <v-btn color="primary" @click="submitCart">Submit Cart</v-btn>
          </v-card-actions>
        </v-card>
        <v-snackbar
          v-model="snackbar"
          :timeout="3000"
          color="success"
        >
          <span>Transaction recorded!</span>
          <template v-slot:action="{ attrs }">
            <v-btn
              color="white"
              text
              v-bind="attrs"
              @click="snackbar = false"
            >
              Close
            </v-btn>
          </template>
        </v-snackbar>
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
  import axios from "axios";

  export default {
    name: "CartComponent",
    data: () => ({
      errorMessage: '',
      loading: false,
      snackbar: false,
      items: [],
      item_qty: 1,
      cart: [],
      selected_item: {id: "", item_name: "", item_price: ""},
      headers: [
        {
          text: 'Item name',
          align: 'start',
          sortable: false,
          value: 'item_name',
        },
        {
          text: 'Item price',
          align: 'start',
          sortable: false,
          value: 'item_price',
        },
        {
          text: 'Item quantity',
          align: 'start',
          sortable: false,
          value: 'item_qty',
        },
        {
          text: 'Item amount',
          align: 'start',
          sortable: false,
          value: 'item_amount',
        },
      ]
    }),
    mounted() {
      this.getAllItems();
    },
    methods: {
      getAllItems() {
        this.loading = true;
        const config = {
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        }
        axios.get("./api/item", config).then((res) => {
          console.log(res);
          this.loading = false;
          if (res.data.error) {
            this.errorMessage = res.data.message;
          } else {
            this.items = res.data.data;
          }
        });
      },
      addToCart() {
        this.cart.push({
          item_id: this.selected_item.id,
          item_name: this.selected_item.item_name,
          item_price: this.selected_item.item_price,
          item_qty: this.item_qty,
          item_amount: parseFloat(
            this.item_qty * this.selected_item.item_price
          ).toFixed(2),
        });
        this.selected_item = {id: "", item_name: "", price: ""};
        this.item_qty = 1;
      },
      submitCart() {
        const cashierId = this.$store.state.user.id;
        if (this.cart.length <= 0) {
          console.log('cart is empty!');
        } else {
          let date = new Date().toISOString().slice(0, 19).replace('T', ' ');
          let formData = new FormData();
          formData.append("cashier_id", cashierId);
          formData.append("date_time", date);
          // Post cart
          const config = {
            headers: {
              'Content-Type': 'application/json',
              'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
          }
          axios.post("./api/cart", formData, config).then((res) => {
            console.log(res.data);
            // GET CART ID
            const config = {
              headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`
              }
            }
            axios.get("./api/cart", config).then((res) => {
              console.log("ID latest", res.data.data.id);
              // Post to Item_Cart
              //Must loop all cart contents
              for (let i = 0; i < this.cart.length; i++) {
                let formData = new FormData();
                formData.append("item_id", this.cart[i].item_id);
                formData.append("cart_id", res.data.data.id);
                formData.append("item_qty", this.cart[i].item_qty);
                const config = {
                  headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                  }
                }
                axios
                  .post("./api/item_cart", formData, config)
                  .then((res) => {
                    console.log(res.data);
                    this.cart = [];
                    this.snackbar = true
                  });
              }
            });
          });
        }
      }
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