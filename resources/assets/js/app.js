import Vue from "vue";
import App from "./App.vue";
import Ideas from "./components/Ideas.vue";
import Example from "./components/ExampleComponent.vue";
import CreateIdea from "./components/CreateIdea.vue";
import Register from "./components/Register.vue";
import Login from "./components/Login.vue";
import Projects from "./components/Projects.vue";
import ProjectDetails from "./components/ProjectDetails.vue";
import CreateProject from "./components/CreateProject.vue";
import VueRouter from "vue-router";
import Snotify from "vue-snotify";
import "vuetify/dist/vuetify.min.css";
import "vue-snotify/styles/material.css";
import Vuetify from "vuetify";
Vue.use(Vuetify);
Vue.use(VueRouter);
Vue.use(Snotify);

import VueAxios from "vue-axios";
import axios from "axios";
axios.defaults.baseURL = "http://localhost:8000/api";
Vue.use(VueAxios, axios);

Vue.filter("formatCount", function formatCount(data) {
  if (data == null) {
    return 0;
  }
  return data;
});

const router = new VueRouter({
  routes: [
    {
      path: "/",
      name: "home",
      component: Projects
    },
    {
      path: "/register",
      name: "register",
      component: Register,
      meta: {
        auth: false
      }
    },
    {
      path: "/login",
      name: "login",
      component: Login,
      meta: {
        auth: false
      }
    },
    {
      path: "/project/create",
      name: "CreateProject",
      component: CreateProject,
      meta: {
        auth: true
      }
    },
    {
      path: "/project/:projectId",
      name: "ProjectDetails",
      component: ProjectDetails
    }
  ]
});

Vue.router = router;

Vue.use(require("@websanova/vue-auth"), {
  auth: require("@websanova/vue-auth/drivers/auth/bearer.js"),
  http: require("@websanova/vue-auth/drivers/http/axios.1.x.js"),
  router: require("@websanova/vue-auth/drivers/router/vue-router.2.x.js")
});

App.router = Vue.router;

new Vue(App).$mount("#app");
