<template>
  <div class="card">
    <div class="card-body">
      <h3>Produk</h3>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th></th>
              <th>Nama</th>
              <th>Harga</th>
              <th>Deskripsi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="getProduct.length < 1">
              <td colspan="4" class="text-center bg-light">
                Belum ada data produk.
              </td>
            </tr>
            <tr v-for="(item, index) in getProduct" :key="item.id">
              <td>
                <button
                  type="button"
                  class="btn btn-sm btn-primary"
                  @click.prevent="addProduct(index, item)"
                >
                  +
                </button>
              </td>
              <td>{{ item.name }}</td>
              <td>Rp {{ item.price }}</td>
              <td>
                {{ item.about }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  props: ["excludeproduct"],
  data() {
    return {
      products: [],
    };
  },
  computed: {
    ...mapGetters(["getProduct", "getProductPackage"]),
  },
  mounted() {
    // console.log(this.excludeproduct);
    axios
      .get("/product")
      .then((res) => {
        // console.log(res);
        this.$store.commit("ADD_PRODUCT", res.data.data);
        this.excludeproduct.forEach((item) => {
          this.addProductToPackage(item);
        });
      })
      .catch((err) => {
        console.log(err);
      });
  },
  methods: {
    ...mapActions(["addProductToPackage", "deleteProduct"]),
    addProduct(index, item) {
      //   this.deleteProduct(item);
      this.addProductToPackage(item);
    },
  },
};
</script>