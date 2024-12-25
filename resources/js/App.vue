<template>
  <div class="container mt-5">
    <h1 class="text-center">Meter Reading Form</h1>
    <AddReading />
  </div>
</template>

<script>
import AddReading from "./meter/add-reading.vue";
import Toast from "./meter/toast.vue";

export default {

  components: {
    AddReading,
  },

  data() {
    return {


    };
  },
  methods: {

  }
};
</script>

<style>
/* Optional custom styles */
</style>
