<template>
  <div>
    <h1 class="text-center">Set Last Month Reading</h1>
    <form @submit.prevent="submitLastMonthReadingForm" class="mb-5">
      <div class="mb-3">
        <label for="meter_name" class="form-label">Meter Name:</label>
        <select v-model="meter_name" id="meter_name" class="form-select" required>
          <option v-for="(stat, index) in stats" :key="index" :value="stat.meter_name">
            {{ stat.label }}
          </option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Reading Value:</label>
      <input type="number" v-model="reading_value" class="form-control" required />
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-success">Submit</button>
      </div>
    </form>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      meter_name: "",
      reading_value: "",
    };
  },
  methods: {
    async submitLastMonthReadingForm() {
      try {
        const data = {
          reading_value: this.reading_value,
        };
        const response = await axios.put(
          `/set-reading/${this.meter_name}`,
          data
        );

        console.log(response.data);
        this.$swal(response.data.message);
        this.reading_value = "";
      } catch (error) {
        console.error("Error submitting meter reading:", error);
        this.$swal(
          error.response?.data?.message ||
          "An error occurred. Please try again."
        );
      }
    },
  },

  computed: {
    stats() {
      return this.$store.state.stats;
    }
  }
};
</script>
