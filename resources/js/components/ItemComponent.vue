<template>
  <div class="container">
    <div class="row">

      <div class="col-8 offset-2">
        <div class="card" style="width: 100%;">
          <div class="card-header text-center">Items</div>
          <div class="card-body">

            <div class="form-inline">
              <div class="form-group mx-sm-3 mb-2">
                <label class="sr-only">Item name</label>
                <input v-model="newItemName" type="text" class="form-control" placeholder="Item name">
              </div>
              <div class="form-group mx-sm-3 mb-2">
                <label class="sr-only">Item price</label>
                <input v-model="newItemPrice" type="text" class="form-control" placeholder="Item price">
              </div>
              <button type="button" class="btn btn-primary mb-2" @click="addItem()">Add</button>
            </div>

            <table class="table table-sm mt-2" v-if="!loading">
              <thead class="thead-light">
              <tr>
                <th scope="col">Item name</th>
                <th scope="col">Item price</th>
                <th></th>
                <th></th>
              </tr>
              </thead>
              <tbody v-for="item in items" :key="item.id">
              <tr>
                <td><span v-cloak>{{ item.item_name }}</span></td>
                <td><span v-cloak>{{ item.item_price }}</span></td>
                <td><button @click="openUpdateModal(item.id, item.item_name, item.item_price)" class="btn btn-success btn-sm">edit</button></td>
                <td><button @click="deleteItem(item.id)" class="btn btn-danger btn-sm">delete</button></td>
              </tr>
              </tbody>
            </table>
            <h5 class="text-center" v-else>Loading...</h5>
          </div>
        </div>
      </div>

    </div>

    <div v-cloak v-if="showEditModal">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Update Item</h5>
                  <button @click="showEditModal = false" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div>
                    <div class="form-group">
                      <label>Item Name</label>
                      <input v-model="updateName" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>Item Price</label>
                      <input v-model="updatePrice" type="text" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button @click="showEditModal = false" type="button" class="btn btn-secondary">Close</button>
                  <button @click="updateItem()" type="button" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
  export default {
    name: "ItemComponent",
    data() {
      return {
        loading: false,
        errorMessage: "",
        items: [],
        newItemName: "",
        newItemPrice: "",
        showEditModal: false,
        updateID: "",
        updateName: "",
        updatePrice: "",
      }
    },
    mounted() {
      console.log("Vue js is running 'items page'...");
      this.getAllItems();
    },
    methods: {
      getAllItems() {
        this.loading = true;
        axios.get("./api/item").then((res) => {
          console.log(res);
          this.loading = false;
          if (res.data.error) {
            this.errorMessage = res.data.message;
          } else {
            this.items = res.data.data;
          }
        });
      },
      addItem() {
        const newItem = {
          item_name: this.newItemName,
          item_price: this.newItemPrice,
        };
        let formData = new FormData();
        formData.append("item_name", this.newItemName);
        formData.append("item_price", this.newItemPrice);
        axios.post("./api/item", formData).then((res) => {
          console.log(res);
          this.newItemName = "";
          this.newItemPrice = "";
          this.getAllItems();
        });
      },
      deleteItem(id) {
        console.log(id);
        const config = {
          headers: {
            "Accept": "application/json",
            "Content-Type": "application/json"
          }
        };
        axios.delete(`./api/item/${id}`, config).then((res) => {
          console.log(res);
          this.getAllItems();
        });
      },
      updateItem() {
        console.log(this.updateID);
        let config = {
          headers: {
            "Accept": "application/json",
            "Content-Type": "application/json"
          }
        };
        const updateData = JSON.stringify({
          item_name: this.updateName,
          item_price: this.updatePrice
        });
        axios.put(`./api/item/${this.updateID}`, updateData, config).then((res) => {
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
  }
</script>

<style scoped>

</style>