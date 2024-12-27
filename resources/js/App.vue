<template>
  <div class="container mt-5">

    <h1 class="text-center mb-4">Meter Consumptions</h1>
    <div v-if="loading" class="text-center">Loading...</div>
    <div v-else>
      <div class="row">
        <div class="col-md-3" v-for="(stat, index) in stats" :key="index">
          <Widget :label="stat.label" :value="stat.reading" />
        </div>
      </div>
    </div>

    <div class="row mb-3">
      <button class="btn btn-primary me-3" @click="toggleReadingForm">
        {{ showReadingForm ? 'Hide Reading Form' : 'Show Reading Form' }}
      </button>
    </div>

      <div class="row mb-3">
        <button class="btn btn-success" @click="toggleLastMonthReading">
          {{ showLastMonthReading ? 'Hide Last Month Reading Form' : 'Show Last Month Reading Form' }}
        </button>
      </div>
    <AddReading v-if="showReadingForm" />
    <LastMonthReading v-if="showLastMonthReading" />
  </div>
</template>

<script>
import AddReading from "./meter/add-reading.vue";
import LastMonthReading from "./meter/last-month-reading.vue";
import Widget from "./meter/widget.vue";

export default {
  components: {
    AddReading,
    LastMonthReading,
    Widget,
  },

  data() {
    return {

      loading: true,
      showLastMonthReading: false,
      showReadingForm: false,
    };
  },
  computed: {
    stats() {
      return this.$store.state.stats;
    },
  },
  methods: {
    async fetchStats() {
      try {
        const response = await axios.get("/api/stats");


        this.$store.dispatch('updateSharedData', response.data.data); // Dispatch Vuex action to update stats

        console.log(this.stats);
      } catch (error) {
        this.stats = [];
        console.log(error);
      } finally {
        this.loading = false;
      }
    },

    toggleLastMonthReading() {
      this.showLastMonthReading = !this.showLastMonthReading;
    },

    toggleReadingForm() {
      this.showReadingForm = !this.showReadingForm;
    },
  },
  mounted() {
    this.fetchStats();
  },
};

</script>
