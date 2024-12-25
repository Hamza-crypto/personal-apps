<template>
  <div class="widget card shadow-sm text-center">
    <div class="card-body">
      <h5 class="card-title">{{ label }}</h5>
      <p class="card-text display-6">{{ value }}</p>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    label: {
      type: String,
      required: true,
    },
    value: {
      type: [String, Number],
      required: true,
    },
  },
};
</script>

<style>
.widget {
  border-radius: 10px;
  margin: 10px;
}
.card-title {
  font-size: 1.25rem;
  font-weight: bold;
}
.card-text {
  font-size: 2rem;
  color: #2271b1;
}
</style>
