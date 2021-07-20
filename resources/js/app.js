require("./bootstrap");

// window.Vue = require("vue");
import Vue from "vue";
import store from "./store";
// window.Vue = Vue;

import BootstrapVue from "bootstrap-vue"; //Importing

Vue.use(BootstrapVue);

import VueTimepicker from "vue2-timepicker/src/vue-timepicker.vue";
import moment from "moment";

Vue.prototype.moment = moment;

Vue.component("vue-timepicker", VueTimepicker);
Vue.component("product-list", require("./components/ProductList.vue").default);
Vue.component(
    "product-package-list",
    require("./components/ProductPackageList.vue").default
);
Vue.component(
    "input-reservation",
    require("./components/InputReservation.vue").default
);
Vue.component(
    "change-service-status",
    require("./components/ChangeServiceStatus.vue").default
);
Vue.component(
    "payment-input",
    require("./components/PaymentInput.vue").default
);

// const app = new Vue(Vue.util.extend({}, App)).$mount("#app");
// const app = new Vue().$mount("#app");
const app = new Vue({
    el: "#app",
    store
});

jQuery("[data-toggle='tooltip']").tooltip();
