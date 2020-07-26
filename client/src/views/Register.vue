<template>
  <div class="register">
    <v-layout>
      <v-flex sm12 md6 offset-md3>
        <v-card outlined class="my-6 pa-6">
          <v-card-title>
            <span class="subtitle-1 font-weight-light">Register</span>
          </v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="12" md="10" offset="1">
                <v-text-field v-model="newUser.name" dense outlined label="Name"></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="10" offset="1">
                <v-text-field v-model="newUser.email" dense outlined label="Email"></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="10" offset="1">
                <v-text-field
                  v-model="newUser.password" dense outlined
                  label="Password"
                  :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                  :type="showPassword ? 'text' : 'password'"
                  @click:append="showPassword = !showPassword"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="10" offset="1">
                <v-text-field
                  v-model="newUser.confirmPassword" dense outlined
                  label="Confirm Password"
                  :append-icon="showConfirmPassword ? 'mdi-eye' : 'mdi-eye-off'"
                  :type="showConfirmPassword ? 'text' : 'password'"
                  @click:append="showConfirmPassword = !showConfirmPassword"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions class="justify-center">
            <v-btn color="primary" @click="register">Register</v-btn>
          </v-card-actions>
        </v-card>
        <v-snackbar
          v-model="snackbar"
          :timeout="3000"
          color="error"
        >
          <span>{{ this.errorMessage }}</span>
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
  import {mapActions, mapState} from 'vuex'

  export default {
    name: "Register",
    data: () => ({
      showPassword: false,
      showConfirmPassword: false,
      errorMessage: '',
      snackbar: false,
      newUser: {
        name: '',
        email: '',
        password: '',
        confirmPassword: '',
      }
    }),
    beforeCreate() {
      if (this.$store.state.isAuthenticated) {
        this.$router.push('/', () => {
        })
      }
    },
    methods: {
      ...mapActions(['registerUser']),
      register() {
        if (this.newUser.password === this.newUser.confirmPassword && this.newUser.password.length >= 8) {
          this.registerUser(this.newUser);
          this.newUser = {
            name: '',
            email: '',
            password: '',
            confirmPassword: '',
          }
        } else if (this.errorType === "REGISTER_ERROR") {
          this.errorMessage = this.$store.state.errorMessage
          this.snackbar = true
        } else {
          this.errorMessage = "Password not the same or length is less than 8 characters";
          this.snackbar = true
        }
      }
    },
    computed: {
      ...mapState(["errorType"])
    },
    watch: {
      errorType() {
        if (this.errorType === "REGISTER_ERROR") {
          this.errorMessage = this.$store.state.errorMessage
          this.snackbar = true
        }
      }
    }
  }
</script>

<style scoped>

</style>