<template>
  <div>
    <h1 class="text-center">Meter Reading Form</h1>
  <form @submit.prevent="submitForm" class="mb-5">
    <div class="mb-3">
      <label for="meter_name" class="form-label">Meter Name:</label>
      <select v-model="meter_name" id="meter_name" class="form-select" required>
          <option v-for="(stat, index) in stats" :key="index" :value="stat.meter_name">
            {{ stat.label }}
          </option>
        </select>
    </div>
    <div class="mb-3">
      <label for="reading_value" class="form-label">Reading Value:</label>
      <input type="number" v-model="reading_value" id="reading_value" class="form-control" required />
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Submit</button>
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
    async submitForm() {
      try {
        const data = {
          reading_value: this.reading_value,
        };
        // Post the form data to the Laravel backend
        const response = await axios.put(
          `/meter-readings/${this.meter_name}`,
          data
        );

        console.log(response.data);
        this.$swal(response.data.message);
        // Reset the form
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

