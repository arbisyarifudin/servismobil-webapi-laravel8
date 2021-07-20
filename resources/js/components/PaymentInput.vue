<template>
  <div>
    <div class="mb-3">
      <label>Tagihan</label>
      <input
        type="hidden"
        class="form-control"
        name="bill"
        :value="bill"
        required
        readonly
      />
      <div class="form-control" disabled readonly>Rp {{ rupiah(bill) }}</div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="mb-3">
          <label>Pembayaran</label>
          <input
            type="number"
            class="form-control"
            name="pay"
            v-model="pay"
            required
            :min="bill"
            ref="pay"
          />
        </div>
      </div>
      <div class="col-md-6 d-none">
        <div class="mb-3">
          <label>Metode</label>
          <select
            type="number"
            class="form-control"
            name="method"
            v-model="method"
            required
          >
            <option value="Cash">Tunai</option>
            <option value="Card">Kartu</option>
          </select>
        </div>
      </div>
    </div>
    <div class="mb-3">
      <label>Kembalian</label>
      <input
        type="hidden"
        class="form-control"
        name="change"
        readonly
        :value="paymentChange"
        ref="change"
      />
      <div class="form-control" disabled readonly>
        Rp {{ rupiah(paymentChange) }}
      </div>
    </div>
    <hr />
    <button type="submit" class="btn btn-primary" :disabled="paymentChange < 0">
      Simpan
    </button>
    <slot></slot>
  </div>
</template>

<script>
export default {
  props: ["bill"],
  data() {
    return {
      pay: 100000,
      method: "Cash",
    };
  },
  mounted() {
    console.log(this.$refs);
  },
  computed: {
    paymentChange() {
      return this.pay - this.bill;
    },
  },
  methods: {
    rupiah(num) {
      return num.toLocaleString("id");
    },
  },
};
</script>

<style scoped>
button:disabled {
  cursor: not-allowed;
}
</style>