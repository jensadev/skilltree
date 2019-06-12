<template>
  <div class="card skillcard" draggable="true">
    <h5 class="card-title">{{ title }}</h5>
    <div class="card-body">{{ description }}</div>
  </div>
</template>
<script>
export default {
  data() {
    return {};
  },
  props: ["title", "description"]
};
</script>
<style>
.skillcard {
  width: 18rem;
}
</style>
