<template>
  <div class="transactions">
    <v-layout>
      <v-flex md5>
        <v-card outlined class="my-6 ml-4 pa-4">
          <v-card-title>
            <span class="subtitle-1 font-weight-light">Transactions</span>
          </v-card-title>
          <v-card-text>

            <v-data-table
              dense
              class="elevation-3"
              :loading="loading"
              loading-text="loading..."
              :items="transactions"
              :headers="headers"
            >
              <template v-slot:item.actions="{ item }">
                <v-btn color="primary"
                       small @click="viewDetails(item.id)"
                >
                  details
                </v-btn>
              </template>
            </v-data-table>

          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex md7>
        <v-card outlined class="my-6 ml-4 pa-4 mr-5">
          <v-card-title>
            <span class="subtitle-1 font-weight-light">Transaction Details</span>
          </v-card-title>
          <v-card-text>

            <p class="subtitle-2">Cashier name: {{ cashierName }}</p>
            <p class="subtitle-2">Date: {{ date }}</p>

            <v-data-table
              dense
              class="elevation-3"
              :loading="loading"
              loading-text="loading..."
              :items="formatTransactions"
              :headers="headers_details"
              :hide-default-footer="true"
            >
            </v-data-table>

            <v-row>
              <span class="subtitle-2 mt-3">Total amount: {{this.totalAmount}}</span>
            </v-row>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
  import axios from "axios";

  export default {
    name: "TransactionComponent",
    data: () => ({
      loading: '',
      errorMessage: '',
      cashierName: '',
      date: '',
      transactions: [],
      transactionDetails: [],
      headers: [
        {
          text: 'Cart ID',
          align: 'start',
          sortable: false,
          value: 'id',
        },
        {
          text: 'Cashier name',
          align: 'start',
          sortable: false,
          value: 'name',
        },
        {
          text: 'Date',
          align: 'start',
          sortable: false,
          value: 'date_time',
        },
        {text: 'Actions', align: 'center', value: 'actions', sortable: false}
      ],
      headers_details: [
        {
          text: 'Item name',
          align: 'start',
          sortable: false,
          value: 'item_name',
        },
        {
          text: 'Price',
          align: 'start',
          sortable: false,
          value: 'item_price',
        },
        {
          text: 'Quantity',
          align: 'start',
          sortable: false,
          value: 'item_qty',
        },
        {
          text: 'Amount',
          align: 'start',
          sortable: false,
          value: 'amount',
        },
      ]
    }),
    mounted() {
      this.getAllTransactions()
    },
    methods: {
      getAllTransactions() {
        this.loading = true;
        const config = {
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        }
        axios.get("./api/transaction", config).then((res) => {
          console.log(res);
          this.loading = false;
          if (res.data.error) {
            this.errorMessage = res.data.message;
          } else {
            this.transactions = res.data.data;
          }
        });
      },
      viewDetails(id) {
        console.log(id);
        const config = {
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        }
        axios
          .get(`./api/transaction/${id}`, config)
          .then((res) => {
            console.log(res);
            this.cashierName = res.data.data[0].name;
            this.date = res.data.data[0].date_time;
            this.transactionDetails = res.data.data;
          });
      },
    },
    computed: {
      totalAmount() {
        let amount = this.transactionDetails.map((item) => {
          let amount = parseFloat(item.item_price * item.item_qty);
          return amount;
        });
        const sumTotal = (amount) => amount.reduce((a, b) => a + b, 0);
        const sum = sumTotal(amount);
        return parseFloat(sum).toFixed(2);
      },
      formatTransactions() {
        let transactions = this.transactionDetails.map(item => {
          const item_amount = parseFloat(item.item_qty * item.item_price).toFixed(2)
          let new_item = {
            ...item,
            amount: item_amount
          }
          return new_item
        })
        return transactions
      }
    },
  }
</script>

<style scoped>

</style>