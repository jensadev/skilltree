<template>
  <div class="dashbar position-absolute d-flex w-100 justify-content-end">
    <!-- trigger -->
    <button class="dashbaricon btn">
      <slot name="add"></slot>
    </button>
    <button class="dashbaricon btn" @click="isOpen = !isOpen">
      <slot name="trigger"></slot>
    </button>
    <!-- content -->
    <div v-show="isOpen" class="dashbar-content position-absolute w-25">
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
          .getElementById("dashbarclose")
          .addEventListener("click", this.closebar);
      }
    }
  },
  methods: {
    closebar(e) {
      this.isOpen = false;
    }
  }
};
</script>
