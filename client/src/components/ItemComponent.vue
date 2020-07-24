<template>
  <div class="item">
    <v-layout>
      <v-flex sm12 md8 offset-md2>
        <v-card outlined class="my-6 pa-4">
          <v-card-title>
            <span class="subtitle-1 font-weight-light">Items</span>
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
            <v-col cols="12" md="1">
              <v-btn class="mx-2" small fab dark color="primary" @click="addDialog=true">
                <v-icon dark>mdi-plus</v-icon>
              </v-btn>
            </v-col>
          </v-card-title>
          <v-card-text>
            <!--Update Dialog-->
            <v-dialog v-model="updateDialog" max-width="500px">
              <v-card>
                <v-card-title>
                  <span class="subtitle-1">Edit item</span>
                </v-card-title>

                <v-card-text>
                  <v-container>
                    <v-row>
                      <v-col cols="12" md="6">
                        <v-text-field
                          v-model="editedItem.item_name"
                          label="Item"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" md="6">
                        <v-text-field
                          v-model="editedItem.item_price"
                          label="Price"
                        ></v-text-field>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="updateDialog = false">Cancel</v-btn>
                  <v-btn color="blue darken-1" text @click="updateItem">Save</v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
            <!--Add Dialog-->
            <v-dialog v-model="addDialog" max-width="500px">
              <v-card>
                <v-card-title>
                  <span class="subtitle-1">Edit item</span>
                </v-card-title>

                <v-card-text>
                  <v-container>
                    <v-row>
                      <v-col cols="12" md="6">
                        <v-text-field
                          v-model="newItem.item_name"
                          label="Item"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" md="6">
                        <v-text-field
                          v-model="newItem.item_price"
                          label="Price"
                        ></v-text-field>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="addDialog = false">Cancel</v-btn>
                  <v-btn color="blue darken-1" text @click="addItem">Save</v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
            <!--Data table Items-->
            <v-data-table
              class="elevation-3"
              dense
              :loading="loading"
              :headers="headers"
              :items="items"
              :search="search"
            >
              <template v-slot:item.actions="{ item }">
                <v-btn text color="primary"
                       @click="editItem(item)"
                >
                  <v-icon
                    small
                  >
                    mdi-pencil
                  </v-icon>
                </v-btn>
                <v-btn text color="error"
                       @click="deleteItem(item.id)"
                >
                  <v-icon
                    small
                  >
                    mdi-delete
                  </v-icon>
                </v-btn>
              </template>
            </v-data-table>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
  import axios from 'axios'

  export default {
    name: "ItemComponent",
    data: () => ({
      errorMessage: '',
      loading: false,
      items: [],
      updateDialog: false,
      addDialog: false,
      search: '',
      headers: [
        {
          text: 'Item name',
          align: 'start',
          sortable: true,
          value: 'item_name',
        },
        {text: 'Item price', value: 'item_price'},
        {text: 'Actions', align: 'center', value: 'actions', sortable: false}
      ],
      newItem: {
        item_name: '',
        item_price: ""
      },
      editedItem: {
        id: 0,
        item_name: '',
        item_price: 0.00
      }
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
      deleteItem(id) {
        const config = {
          headers: {
            "Accept": "application/json",
            "Content-Type": "application/json",
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        };
        axios.delete(`./api/item/${id}`, config).then((res) => {
          console.log(res);
          this.getAllItems();
        });
      },
      addItem() {
        let formData = new FormData();
        const config = {
          headers: {
            "Accept": "application/json",
            "Content-Type": "application/json",
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        };
        formData.append("item_name", this.newItem.item_name);
        formData.append("item_price", this.newItem.item_price);
        axios.post("./api/item", formData, config).then((res) => {
          console.log(res);
          this.newItem.item_name = "";
          this.newItem.item_price = "";
          this.addDialog = false;
          this.getAllItems();
        });
      },
      updateItem() {
        let config = {
          headers: {
            "Accept": "application/json",
            "Content-Type": "application/json",
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        };
        const updateData = JSON.stringify({
          item_name: this.editedItem.item_name,
          item_price: this.editedItem.item_price,
        });
        axios.put(`./api/item/${this.editedItem.id}`, updateData, config).then((res) => {
          console.log(res);
          this.updateDialog = false;
          this.getAllItems();
        });
      },
      editItem(item) {
        this.editedItem = Object.assign({}, item);
        this.updateDialog = true
      }
    }
  }
</script>

<style scoped>

</style>
