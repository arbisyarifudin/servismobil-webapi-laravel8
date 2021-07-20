<template>
  <div class="row">
    <div class="col-md-6 mb-md-0 mb-3">
      <div class="row">
        <div class="col-12 mb-3">
          <label for="customer">Pelanggan</label>
          <select
            id="customer"
            class="form-control"
            name="customer_id"
            v-model="customer_id"
            @change="getVehicles()"
            required
          >
            <option value="">--Pilih--</option>
            <option
              :value="item.id"
              v-for="item in customers"
              :key="'c' + item.id"
            >
              {{ item.name }}
            </option>
          </select>
        </div>
        <div class="col-12 mb-3" v-if="vehicles && vehicles.length > 0">
          <label for="vehicle">Kendaraan Pelanggan</label>
          <select
            id="vehicle"
            class="form-control"
            name="vehicle_id"
            v-model="vehicle_id"
            required
          >
            <option value="">--Pilih--</option>
            <option
              :value="item.id"
              v-for="item in vehicles"
              :key="'v' + item.id"
            >
              {{ item.name }}
            </option>
          </select>
        </div>
        <div
          class="col-12 mb-3"
          v-else-if="vehicles && vehicles.length < 1 && customer_id"
        >
          <div class="alert alert-warning">
            Pelanggan belum memiliki kendaraan. Silakan
            <a :href="'/vehicle/create/?ref_customer=' + customer_id"
              >tambahkan</a
            >
            terlebih dahulu.
          </div>
        </div>
        <div class="col-12 mb-3" v-if="vehicle_id != ''">
          <label for="vehicle_complaint">Keluhan Kendaraan</label>
          <textarea
            name="vehicle_complaint"
            id="vehicle_complaint"
            class="form-control"
            required
          ></textarea>
        </div>
        <div class="col-12 mb-3">
          <label for="reservation_date">Tanggal Reservasi</label>
          <input
            type="date"
            name="reservation_date"
            id="reservation_date"
            class="form-control"
            :min="minReservation"
            required
          />
        </div>
        <div class="col-12 mb-3">
          <label for="reservation_time">Jam Reservasi</label>
          <input
            type="hidden"
            :value="`${reservation_time.HH}:${reservation_time.mm}`"
            name="reservation_time"
            id="reservation_time"
            class="form-control"
          />
          <div>
            <vue-timepicker
              input-width="100%"
              format="HH:mm"
              :minute-interval="30"
              :hour-range="[9, 10, 11, 13, 14, 15, 16]"
              auto-scroll
              v-model="reservation_time"
              required
            >
            </vue-timepicker>
          </div>
          <input type="hidden" name="reservation_origin" value="Offline" />
          <input
            type="hidden"
            name="products"
            :value="JSON.stringify(products)"
          />
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-md-0 mb-3">
      <div class="row">
        <div class="col-12 mb-3">
          <label for="package">Paket Layanan</label>
          <select
            id="package"
            class="form-control"
            name="package_id"
            v-model="package_id"
            required
            @change="getProducts"
          >
            <option value="">--Pilih--</option>
            <option
              :value="item.id"
              v-for="item in packages"
              :key="'pc' + item.id"
            >
              {{ item.name }}
            </option>
          </select>
        </div>
        <div class="col-12 mb-3" v-if="products && products.length > 0">
          <label for="vehicle">Produk/Komponen Paket Layanan</label>
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Harga</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, i) in products" :key="'p' + item.id">
                <td>{{ i + 1 }}</td>
                <td>{{ item.name }}</td>
                <td>
                  <div class="d-flex justify-content-between">
                    <span>Rp</span> <span>{{ item.price }}</span>
                  </div>
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <th colspan="2">Total</th>
                <th>
                  <div class="d-flex justify-content-between">
                    <span>Rp</span> <span>{{ productTotalPrice }}</span>
                  </div>
                </th>
              </tr>
            </tfoot>
          </table>
        </div>
        <div
          class="col-12 mb-3"
          v-else-if="products && products.length < 1 && package_id"
        >
          <div class="alert alert-warning">
            Paket layanan belum memiliki produk/komponen. Silakan
            <a :href="'/package/' + package_id + '/edit'">tambahkan</a>
            terlebih dahulu.
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      customers: [],
      customer_id: "",
      packages: [],
      package_id: "",
      vehicles: [],
      vehicle_id: "",
      products: [],
      reservation_time: {
        HH: "09",
        mm: "00",
      },
    };
  },
  async mounted() {
    this.customers = await axios
      .get("customer")
      .then((response) => {
        return response.data.data;
      })
      .catch((error) => {
        console.log(error);
      });
    this.packages = await axios
      .get("package")
      .then((response) => {
        return response.data.data;
      })
      .catch((error) => {
        console.log(error);
      });
  },
  computed: {
    productTotalPrice() {
      let total = 0;

      this.products.forEach((item) => {
        total += item.price;
      });

      return total;
    },
    minReservation() {
      //   return this.moment().add(1, "days").format("YYYY-MM-DD");
      return this.moment().format("YYYY-MM-DD");
    },
  },
  methods: {
    getVehicles() {
      if (this.customer_id) {
        const customer_selected = this.customers.filter((item) => {
          return item.id == this.customer_id;
        });

        if (customer_selected && customer_selected.length > 0) {
          this.vehicles = customer_selected[0].vehicles;
          if (this.vehicles && this.vehicles.length > 0) {
            this.vehicle_id = this.vehicles[0].id;
          }
        }
      } else {
        this.vehicles = [];
      }
      if (this.vehicles && this.vehicles.length == 0) {
        this.vehicle_id = "";
      }
    },
    getProducts() {
      if (this.package_id) {
        const package_selected = this.packages.filter((item) => {
          return item.id == this.package_id;
        });

        if (package_selected && package_selected.length > 0) {
          this.products = package_selected[0].products;
        }
      } else {
        this.products = [];
      }
    },
  },
};
</script>