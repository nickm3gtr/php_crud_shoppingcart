<template>
  <div class="login">
    <v-layout>
      <v-flex sm12 md6 offset-md3>
        <v-card outlined class="my-6 pa-6">
          <v-card-title>
            <span class="subtitle-1 font-weight-light">Login</span>
          </v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="12" md="10" offset="1">
                <v-text-field v-model="username" dense outlined label="Email"></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="10" offset="1">
                <v-text-field v-model="password" dense outlined label="Password" type="password"></v-text-field>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions class="justify-center">
            <v-btn @click="submitLogin" color="primary">Login</v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
  import { mapActions } from 'vuex'

  export default {
    name: "Login",
    data: () => ({
      username: '',
      password: '',
    }),
    beforeCreate() {
      if(this.$store.state.isAuthenticated) {
        this.$router.push('/', () => {})
      }
    },
    methods: {
      ...mapActions(['loginUser']),
      submitLogin() {
        const payload = {
          username: this.username,
          password: this.password
        }
        this.loginUser(payload);
      }
    }
  }
</script>

<style scoped>

</style>