<template>
  <form @submit.prevent="submitForm" class="mb-5">
    <div class="mb-3">
      <label for="meter_name" class="form-label">Meter Name:</label>
      <select v-model="meter_name" id="meter_name" class="form-select" required>
        <option value="meter1">Meter 1</option>
        <option value="meter2">Meter 2</option>
      </select>
    </div>
    <div class="mb-3">
      <label for="reading_value" class="form-label">Reading Value:</label>
      <input type="number" v-model="reading_value" id="reading_value" class="form-control" required />
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      meter_name: "meter1",
      reading_value: "meter1",
    };
  },
  methods: {
    async submitForm() {
      try {
        const data = {
          meter_name: this.meter_name,
          reading_value: this.reading_value,
        };
        // Post the form data to the Laravel backend
        const response = await axios.put(
          `/meter-readings/${this.meter_name}`,
          data
        );

        console.log(response.data);
        this.$swal("Meter reading updated successfully!");
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
};
</script>
