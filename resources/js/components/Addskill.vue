<template>
  <div class="addskill">
    <!-- trigger -->
    <button class="dashbaricon btn" @click="isOpen = !isOpen">
      <slot name="trigger"></slot>
    </button>
    <!-- content -->
    <div v-show="isOpen" class="addskill-content position-absolute w-50">
      <slot></slot>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      isOpen: false
    };
  },
  watch: {
    isOpen(isOpen) {
      if (isOpen) {
        document
          .getElementById("addskillclose")
          .addEventListener("click", this.closebar);
        document.getElementById("title").autofocus = true;
      }
    }
  },
  methods: {
    closebar() {
      this.isOpen = false;
    }
  }
};
</script>
<style>
.addskill-content {
  right: 0.2rem;
  top: 0.6rem;
  z-index: 5;
}
</style>
