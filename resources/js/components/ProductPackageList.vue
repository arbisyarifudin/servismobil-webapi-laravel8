<template>
  <table class="table">
    <tr v-if="getProductPackage.length < 1">
      <td colspan="6" class="text-center bg-light">
        Tambahkan produk ke paket.
      </td>
    </tr>
    <tr v-for="(item, index) in getProductPackage" :key="index">
      <td>{{ index + 1 }}</td>
      <td>{{ item.name }}</td>
      <td>Rp {{ item.price }}</td>
      <td width="20%">x {{ item.quantity }}</td>
      <td>Rp {{ item.price * item.quantity }}</td>
      <td>
        <!-- <form :action="`/packageproduct/${item.id}`" method="GET" ref="submit"> -->
        <button
          type="button"
          class="btn btn-sm btn-danger"
          @click="deleteProduct({ index, item })"
        >
          x
        </button>
        <!-- </form> -->
      </td>
      <input type="hidden" name="product_id[]" :value="item.id" />
    </tr>
  </table>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  props: ["editmode"],
  mounted() {
    // console.log(this.currentproduct);
    // this.currentproduct.forEach((item) => {
    //   this.addProductToPackage(item);
    // });
  },
  methods: {
    ...mapActions(["deleteProductFromPackage", "addProductToPackage"]),
    deleteProduct(data) {
      // if (this.editmode) {
      //   var r = confirm("Apakah anda yakin?");
      //   if (r) {
      //     // console.log(this.$refs.submit);
      //     this.$refs.submit[data.index].submit();
      //   }
      // } else {
      this.deleteProductFromPackage(data);
      // }
    },
  },
  computed: {
    ...mapGetters(["getProductPackage"]),
  },
};
</script>