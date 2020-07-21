<?php include 'layouts/header.php' ?>

<div id="cart">

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
                <span v-cloak>{{ cashier.cashier_name }}</span>
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

<script src="js/cart.js"></script>

<?php include 'layouts/footer.php' ?>