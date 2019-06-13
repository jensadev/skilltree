<template>
  <div class="sidebar">
    <!-- trigger -->
    <button class="dashbaricon btn" @click="isOpen = !isOpen">
      <slot name="trigger"></slot>
    </button>
    <!-- content -->
    <div v-show="isOpen" class="sidebar-content position-absolute w-25">
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
        document.addEventListener("click", this.closeIfClickedOutside);
      }
    }
  },
  methods: {
    closeIfClickedOutside(event) {
      if (!event.target.closest(".sidebar")) {
        this.isOpen = false;
        document.removeEventListener("click", this.closeIfClickedOutside);
      }
    }
  }
};
</script>
<style>
.sidebar-content {
  right: 0.2rem;
  top: 0.6rem;
  z-index: 5;
}
</style>
