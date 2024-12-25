<template>
  <div class="container mt-5">
    <h1 class="text-center mb-4">Meter Consumptions</h1>

    <div v-if="loading" class="text-center">Loading...</div>
    <div v-else>
      <div class="row">
        <div class="col-md-3" v-for="(stat, index) in stats" :key="index" >
          <Widget :label="stat.label" :value="stat.reading" />
        </div>
      </div>
    </div>
    <h1 class="text-center">Meter Reading Form</h1>
    <AddReading />
  </div>
</template>

<script>
import AddReading from "./meter/add-reading.vue";
import Widget from "./meter/widget.vue";

export default { 
  components: {
    AddReading,
    Widget,
  },

  data() {
    return {

      loading: true,
      widgets: [
        { id: 1, label: "Total Users", value: 120 },
        { id: 2, label: "Active Subscriptions", value: 85 },
        { id: 3, label: "Revenue (USD)", value: "$12,500" },
        { id: 4, label: "Pending Tasks", value: 7 },
      ],
    };
  },
  computed: {
    stats() {
      return this.$store.state.stats; // Access stats from the Vuex store
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
  },
  mounted() {
    this.fetchStats();
  },
};

</script>

<style>
/* Optional custom styles */
</style>
