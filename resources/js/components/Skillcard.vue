<template>
  <div class="card skillcard" draggable="true" v-bind:id="'skill_' + id" :style="style">
    <h5 class="card-title">{{ title }}</h5>
    <div class="card-body">{{ description }}</div>
  </div>
</template>
<script>
export default {
  name: "Skillcard",
  props: ["id", "title", "description", "top", "left"],

  computed: {
    style() {
      return (
        "left: " +
        this.random(200, window.innerHeight - 200) +
        "px; top: " +
        this.random(200, window.innerHeight - 200) +
        "px;"
      );
    }
  },
  data() {
    return {};
  },
  methods: {
    random: function(min, max) {
      return Math.floor(Math.random() * (max - min)) + min;
    }
  }
};
</script>
<style scoped>
.skillcard {
  width: 18rem;
  position: absolute;
}
</style>
