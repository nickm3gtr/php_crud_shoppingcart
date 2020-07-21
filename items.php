<?php include 'layouts/header.php' ?>

<div id="items">

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

<script src="js/items.js"></script>

<?php include 'layouts/footer.php' ?>