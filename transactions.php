<?php include 'layouts/header.php' ?>

<div id="transactions">

  <div class="row">

    <div class="col-6">
      <div class="card">
        <div class="card-header text-center">Transactions</div>
        <div class="card-body">
          <table class="table table-sm mt-2" v-if="!loading">
            <thead class="thead-light">
              <tr>
                <th>Cart ID</th>
                <th scope="col">Cashier</th>
                <th scope="col">Date</th>
                <th></th>
              </tr>
            </thead>
            <tbody v-for="(item, index) in transactions" :key="index">
              <tr>
                <td><span v-cloak>{{ item.id }}</span></td>
                <td><span v-cloak>{{ item.cashier_name }}</span></td>
                <td><span v-cloak>{{ item.date_time }}</span></td>
                <td><button @click="viewDetails(item.id)" class="btn btn-primary btn-sm">details</button></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-6">
      <div class="card">
        <div class="card-header text-center">Transaction Detail: </div>
        <div class="card-body">
          <p>Cashier name: <span v-cloak>{{ cashierName }}</span></p>
          <p>Date: <span v-cloak>{{ date }}</span></p>
          <table class="table table-sm mt-2" v-if="!loading">
            <thead class="thead-light">
              <tr>
                <th>Item name</th>
                <th scope="col">Price</th>
                <th scope="col">Qty</th>
                <th scope="col">Amount</th>
              </tr>
            </thead>
            <tbody v-for="(item, index) in transactionDetails" :key="index">
              <tr>
                <td><span v-cloak>{{ item.item_name }}</span></td>
                <td><span v-cloak>{{ item.item_price }}</span></td>
                <td><span v-cloak>{{ item.item_qty }}</span></td>
                <td><span v-cloak>{{ parseFloat(item.item_qty * item.item_price).toFixed(2) }}</span></td>
              </tr>
            </tbody>
          </table>
          <p>Total Amount: <span v-cloak>{{ totalAmount }}</span></p>
        </div>
      </div>
    </div>

  </div>


</div>


<script src="js/transactions.js"></script>

<?php include 'layouts/footer.php' ?>