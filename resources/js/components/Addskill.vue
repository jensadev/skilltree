<template>
    <div class="addskill">
        <!-- trigger -->
        <button class="dashbaricon btn" @click="isOpen = !isOpen" title="Add a new Skill">
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
                document.addEventListener("click", this.closeIfClickedOutside);
                document.getElementById("title").autofocus = true;
            }
        }
    },
    methods: {
        closeIfClickedOutside(event) {
            if (!event.target.closest(".addskill")) {
                this.isOpen = false;
                document.removeEventListener(
                    "click",
                    this.closeIfClickedOutside
                );
            }
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
