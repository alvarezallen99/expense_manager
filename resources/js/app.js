require("./bootstrap");
import Vue from 'vue';
import Vuetify from "vuetify";
import App from './src/App.vue';
import Routes from './router.js';
import VueRouter from "vue-router";
import VueIziToast from 'vue-izitoast';
import myPlugins from './src/plugins/myPlugins'
import * as wfunctions from './src/plugins/functions'
import '@mdi/font/css/materialdesignicons.css'
import "izitoast/dist/css/iziToast.css";

Vue.use(Vuetify, {
    icons: {
        iconfont: "mdi"
    }
});
Vue.use(VueRouter);
Vue.use(VueIziToast);
Vue.use(myPlugins);

const CryptoJS = require("crypto-js");
window.decrypt = (encrypted) => {
    let key = process.env.MIX_APP_KEY.substr(7);
    var encrypted_json = JSON.parse(atob(encrypted));
    var x = CryptoJS.AES.decrypt(encrypted_json.value, CryptoJS.enc.Base64.parse(key), {
        iv : CryptoJS.enc.Base64.parse(encrypted_json.iv)
    }).toString(CryptoJS.enc.Utf8);
    // Laravel Remove Unecesary Characters
    x = x.substring(x.indexOf(":")+1);
    x = x.substring(x.indexOf(":")+2);
    let result = x.substring(0, x.length - 2);
    return result.trim()
};

// axios
import axios from 'axios'
axios.defaults.withCredentials = true
axios.defaults.headers.common.Authorization = 'Bearer ' + wfunctions.getSecureLocalToken()
Vue.prototype.$http = axios


Vue.config.productionTip = false

const app = new Vue({
    el: "#app",
    router: Routes,
    vuetify: new Vuetify(),
    render: h => h(App)
});

export default app;
