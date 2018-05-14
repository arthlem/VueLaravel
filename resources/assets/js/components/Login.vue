<template>
  <v-container fluid grid-list-md text-xs-center fill-height class="blue darken-1">
    <v-alert type="error" :value="error" transition="slide-y-transition" dismissible>
      Une erreur s'est produite
    </v-alert>
    <v-dialog v-if="loading" v-model="loading" persistent fullscreen content-class="loading-dialog">
      <v-container fill-height>
        <v-layout row justify-center align-center>
          <v-progress-circular indeterminate :size="70" :width="7" color="purple"></v-progress-circular>
        </v-layout>
      </v-container>
    </v-dialog>
    <v-layout v-else row wrap align-center justify-center>
      <v-flex xs12 md4>
        <v-form class="white_bg">
          <h3 class="display-2 mb-2">Connexion</h3>
          <v-text-field label="Email" v-model="email" :rules="emailRules" placeholder="Email"></v-text-field>
          <v-text-field label="Password" v-model="password" :append-icon="e1 ? 'visibility' : 'visibility_off'" :append-icon-cb="() => (e1 = !e1)" :type="e1 ? 'password' : 'text'" placeholder="Mot de passe"></v-text-field>
  
          <v-btn large color="primary" @click="login">
            Se connecter
          </v-btn>
          <v-btn flat to="/register" small>Je n'ai pas encore de compte</v-btn>
        </v-form>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
  export default {
    data() {
      return {
        loading: false,
        e1: true,
        email: null,
        password: null,
        error: false,
        emailRules: [
          v => !!v || "Vous devez entrez une addresse email",
          v =>
          /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
          "Email non valide"
        ],
      };
    },
    methods: {
      login() {
        var app = this;
        
        this.loading = true;
        this.$auth.login({
          params: {
            email: app.email,
            password: app.password
          },
          success: function() {},
          error: function(e) {
            console.log(e);
          },
          rememberMe: true,
          redirect: "/",
          fetchUser: true
        });
      }
    }
  };
</script>

<style scoped>
  .white_bg {
    background-color: white;
    border-radius: 8px;
    padding: 20px;
  }
</style>
