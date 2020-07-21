<?php include 'layouts/header.php' ?>

<div id="cashiers">

  <div class="row">

    <div class="col-8 offset-2">
      <div class="card" style="width: 100%;">
        <div class="card-header text-center">Cashiers</div>
        <div class="card-body">

          <div class="form-inline">
            <div class="form-group mx-sm-3 mb-2">
              <label class="sr-only">Cashier name</label>
              <input v-model="newCashierName" type="text" class="form-control" placeholder="Cashier name">
            </div>
            <button type="button" class="btn btn-primary mb-2" @click="addCashier()">Add</button>
          </div>

          <table class="table table-sm mt-2" v-if="!loading">
            <thead class="thead-light">
              <tr>
                <th scope="col">Cashier name</th>
                <th></th>
              </tr>
            </thead>
            <tbody v-for="item in cashiers" :key="item.id">
              <tr>
                <td><span v-cloak>{{ item.cashier_name }}</span></td>
                <td><button @click="openUpdateModal(item.id, item.cashier_name)" class="btn btn-success btn-sm">edit</button></td>
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
                <h5 class="modal-title">Update Cashier</h5>
                <button @click="showEditModal = false" type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div>
                  <div class="form-group">
                    <label>Cashier Name</label>
                    <input v-model="updateName" type="text" class="form-control">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button @click="showEditModal = false" type="button" class="btn btn-secondary">Close</button>
                <button @click="updateCashier()" type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>

</div>

<script src="js/cashiers.js"></script>

<?php include 'layouts/footer.php' ?>