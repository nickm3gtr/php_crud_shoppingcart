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
                <v-text-field v-model="newUser.password" dense outlined label="Password" type="password"></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="10" offset="1">
                <v-text-field v-model="newUser.confirmPassword" dense outlined label="Confirm Password" type="password"></v-text-field>
              </v-col>
            </v-row>
            <v-row><p class="error--text">{{ errorMessage }}</p> </v-row>
          </v-card-text>
          <v-card-actions class="justify-center">
            <v-btn color="primary" @click="register">Register</v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
  import {mapActions} from 'vuex'

  export default {
    name: "Register",
    data: () => ({
      errorMessage: '',
      newUser: {
        name: '',
        email: '',
        password: '',
        confirmPassword: '',
      }
    }),
    beforeCreate() {
      if(this.$store.state.isAuthenticated) {
        this.$router.push('/', () => {})
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
        } else {
          if (this.$store.state.isError) {
            this.errorMessage = this.$store.state.errorMessage
          } else {
            this.errorMessage = "Password not the same or length is less than 8 characters";
          }
        }
      }
    }
  }
</script>

<style scoped>

</style>