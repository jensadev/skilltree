<template>
    <div class="centered loader" v-if="loading">
        <div class="spinner-border text-info" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false
        };
    },
    created() {
        window.events.$on("onCenterLoading", () => {
            if (this.loading == false) {
                this.loading = true;
            } else {
                this.loading = false;
            }
        });
        window.events.$on("studentLoad", id => {
            this.loadStorage(id);
        });
    },
    methods: {
        async loadStorage(id) {
            this.loading = true;
            this.loading = false;
        }
    }
};
</script>

<style>
</style>
