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
            await axios
                .get("/skilltrees/" + id + "/pos")
                .then(function(response) {
                    sessionStorage.setItem(
                        id,
                        JSON.stringify(response.data.message.value)
                    );
                    location.reload();
                })
                .catch(function(error) {
                    flash({ body: error, type: "alert-danger" });
                });
            this.loading = false;
        }
    }
};
</script>

<style>
</style>
