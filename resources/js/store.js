import Vue from "vue/dist/vue.esm.js";
import Vuex from "vuex/dist/vuex";
// import axios from "axios";
// import VueAxios from "vue-axios";
// import VueCookie from "vue-cookie";

Vue.use(Vuex);
// Vue.use(VueAxios, axios);
// Vue.use(Notifications);
// Vue.use(VueCookie);

const state = {
    loading: false,
    isLogin: false,
    tokenAuth: null,
    dataUser: {},
    dataError: {},
    settings: [],
    // dataList: {}
    dataProduct: [],
    dataProductPackage: []
};

const getters = {
    vue(state) {
        return this._vm;
    },
    getProduct: state => {
        return state.dataProduct;
    },
    getProductPackage: state => {
        return state.dataProductPackage;
    }
};

const mutations = {
    set(state, [variable, value]) {
        state[variable] = value;
    },
    // custom
    setData(state, [type, value]) {
        state.dataList[type] = value;
    },
    setUser(state, value) {
        state.dataUser = value;
    },
    ADD_PRODUCT(state, data) {
        state.dataProduct = data;
    },
    DELETE_PRODUCT(state, data) {
        state.dataProduct.push(data.item);
    },
    PACKAGE_ADD_PRODUCT(state, item) {
        if (!state.dataProductPackage.includes(item)) {
            state.dataProductPackage.push({ ...item, quantity: 1 });
            const i = state.dataProduct.map(x => x.id).indexOf(item.id);
            state.dataProduct.splice(i, 1);
        }
        // else {
        //     let arr = [];
        //     state.dataProductPackage.forEach(current => {
        //         if (current.id == item.id) {
        //             arr.push({ ...current, quantity: current.quantity + 1 });
        //         } else {
        //             arr.push(current);
        //         }
        //     });
        // }
    },
    PACKAGE_DELETE_PRODUCT(state, data) {
        // if (!state.dataList["product-package"]) {
        //     state.dataList = { "product-package": [] };
        // }
        state.dataProductPackage.splice(data.index, 1);
        state.dataProduct.unshift(data.item);
    }
};

const actions = {
    test({ commit, state }) {},
    deleteProduct({ commit }, payload) {
        commit("DELETE_PRODUCT", payload);
    },
    addProductToPackage({ commit }, payload) {
        // console.log("PACKAGE_ADD_PRODUCT");
        commit("PACKAGE_ADD_PRODUCT", payload);
    },
    deleteProductFromPackage({ commit }, payload) {
        // console.log("PACKAGE_ADD_PRODUCT");
        commit("PACKAGE_DELETE_PRODUCT", payload);
    }
};

export default new Vuex.Store({
    state,
    getters,
    mutations,
    actions
});
