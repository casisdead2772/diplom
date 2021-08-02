import Vue from "vue";
import VuetifyAdmin from "vuetify-admin";

import "vuetify-admin/src/loader";

import {
  laravelDataProvider,
  jwtAuthProvider,
} from "vuetify-admin/src/providers";
import { en, fr } from "vuetify-admin/src/locales";

import router from "@/router";
import routes from "@/router/admin";
import store from "@/store";
import i18n from "@/i18n";
import resources from "@/resources";
import axios from "axios";
import trimEnd from "lodash/trimEnd";

/**
 * Load Admin UI components
 */
Vue.use(VuetifyAdmin);

/**
 * Axios instance
 */
const baseURL = process.env.BASE_URL || "http://localhost:8000/";

const http = axios.create({
  baseURL,
  withCredentials: true,
  headers: {
    "X-Requested-With": "XMLHttpRequest",
    'Access-Control-Allow-Origin': '*',
    'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE, PATCH, OPTIONS',
    'Access-Control-Allow-Headers': 'Origin, X-Requested-With, Content-Type, Authorization',
  }
});

const auth = {
    routes: {
      login: "api/admin/auth/login",
      logout: "api/admin/auth/logout",
      refresh: "api/admin/auth/refresh",
      // user: "api/admin/auth/me",
    },
    storageKey: "jwt_token",
    getToken: (r) => r.data.access_token,
}

export default new VuetifyAdmin({
  router,
  store,
  i18n,
  title: "Bookstore Admin",
  routes,
  locales: { en, fr },
  translations: ["en", "fr"],
  authProvider: jwtAuthProvider(http, auth),
  dataProvider: laravelDataProvider(http),
  resources,
  http,
  options: {
    dateFormat: "long",
    tinyMCE: {
      language: navigator.language.replace("-", "_"),
      imageUploadUrl: "/api/upload",
      fileBrowserUrl: `${trimEnd(baseURL, "/")}/elfinder/tinymce5`,
    },
  },
});
