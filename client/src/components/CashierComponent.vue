<template>
  <div class="cashier">
    <v-layout>
      <v-flex sm12 md8 offset-md2>
        <v-card outlined class="my-6 pa-4">
          <v-card-title>
            <span class="subtitle-1 font-weight-light">Cashiers</span>
            <v-spacer></v-spacer>
            <v-col cols="12" md="4">
              <v-text-field
                dense
                v-model="search"
                append-icon="mdi-magnify"
                label="Search"
                single-line
                hide-details
              ></v-text-field>
            </v-col>
          </v-card-title>
          <v-card-text>
            <v-data-table
              class="elevation-3"
              dense
              :loading="loading"
              loading-text="loading..."
              :headers="headers"
              :items="cashiers"
              :search="search"
            ></v-data-table>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
  import axios from 'axios'

  export default {
    name: "CashierComponent",
    data: () => ({
      loading: false,
      search: '',
      cashiers: [],
      headers: [
        {
          text: 'Name',
          align: 'start',
          sortable: true,
          value: 'name',
        },
        {text: 'Email', value: 'email'},
      ],
    }),
    mounted() {
      this.getAllCashiers();
    },
    methods: {
      getAllCashiers() {
        this.loading = true;
        axios.get("./api/cashier").then((res) => {
          this.loading = false;
          console.log(res);
          if (res.data.error) {
            this.errorMessage = res.data.message;
          } else {
            this.cashiers = res.data.data;
          }
        });
      }
    }
  }
</script>

<style scoped>

</style>
