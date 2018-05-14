<template>
  <v-layout column>
    <v-alert type="error" :value="error" transition="slide-y-transition" dismissible>
      Une erreur s'est produite
    </v-alert>
    <v-container fluid grid-list-md text-xs-center fill-height class="blue darken-1">
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
            <h3 class="display-2 mb-2">Inscription</h3>
            <v-text-field label="Nom" v-model="name" placeholder="Nom"></v-text-field>
            <v-text-field label="Email" v-model="email" :rules="emailRules" placeholder="Email"></v-text-field>
            <v-text-field label="Mot de passe" v-model="password" :append-icon="e1 ? 'visibility' : 'visibility_off'" :append-icon-cb="() => (e1 = !e1)" :type="e1 ? 'password' : 'text'" placeholder="Mot de passe"></v-text-field>
  
            <v-btn large color="primary" @click="register">
              S'inscrire'
            </v-btn>
            <v-btn flat to="/login" small>J'ai déjà un compte</v-btn>
          </v-form>
        </v-flex>
      </v-layout>
    </v-container>
  </v-layout>
</template>

<script>
  export default {
    data() {
      return {
        e1: false,
        name: "",
        email: "",
        password: "",
        error: false,
        errors: {},
        success: false,
        loading: false,
        emailRules: [
          v => !!v || "Vous devez entrez une addresse email",
          v =>
          /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
          "Email non valide"
        ],
      };
    },
    methods: {
      register() {
        var app = this;
        this.$auth.register({
          params: {
            name: app.name,
            email: app.email,
            password: app.password
          },
          success: function() {
            app.success = true;
          },
          error: function(resp) {
            app.error = true;
            app.errors = resp.response.data.errors;
          },
          redirect: "/login"
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