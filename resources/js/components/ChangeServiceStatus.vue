<template>
  <div>
    <select
      name="status"
      class="form-control"
      v-model="status"
      @change="changeStatus($event)"
      no-close-on-backdrop
      no-close-on-esc
    >
      <option value="Pending">Pending</option>
      <option value="Process">Proses</option>
    </select>
    <b-modal
      title="Proses Servis"
      id="modal-status"
      @close="resetModal"
      @hidden="resetModal"
      hide-footer
    >
      <form :action="`/service/${data.id}?ref=reservation`" method="POST">
        <input type="hidden" name="_token" :value="csrfToken" />
        <input type="hidden" name="_method" value="put" />
        <input type="hidden" name="status" :value="status" />
        <p>Mohon pilih Montir untuk melanjutkan ke proses servis.</p>
        <select name="mechanic_id" v-model="mechanic_id" class="form-control">
          <option value="">--Pilih---</option>
          <option
            :value="item.id"
            v-for="item in mechanics"
            :key="'m' + item.id"
          >
            {{ item.name }}
          </option>
        </select>
        <hr />
        <div class="d-flex justify-content-end">
          <button
            class="btn btn-outline-primary"
            type="button"
            @click="$bvModal.hide('modal-status')"
          >
            Batal
          </button>
          <button class="btn btn-primary ml-2" type="submit">Simpan</button>
        </div>
      </form>
    </b-modal>
  </div>
</template>

<script>
export default {
  props: ["data"],
  data() {
    return {
      status: "",
      mechanic_id: "",
      mechanics: [],
    };
  },
  async mounted() {
    this.status = this.data.status;
    this.mechanics = await axios
      .get("mechanic")
      .then((response) => {
        return response.data.data;
      })
      .catch((error) => {
        console.log(error);
      });
  },
  computed: {
    csrfToken() {
      return document.head.querySelector('meta[name="csrf-token"]').content;
    },
  },
  methods: {
    resetModal() {
      this.status = this.data.status;
    },
    changeStatus(event) {
      console.log(this.status);
      if (this.status == "Pending") {
        event.target.form.submit();
      } else {
        this.$bvModal.show("modal-status");
      }
    },
  },
};
</script>