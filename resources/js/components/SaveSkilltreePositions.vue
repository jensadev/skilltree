<template>
    <div class="save-skilltree-positions">
        <button
            class="btn dashbaricon"
            @click.prevent="restorePositions"
            title="Restore Skilltree positions"
            v-bind="{isLoading}"
            :disabled="isLoading"
        >
            <i class="material-icons" v-if="isLoading == false">restore_page</i>
            <div
                class="spinner-border"
                role="status"
                v-if="isLoading"
                style="width:24px; height:24px; margin-left:14px;"
            >
                <span class="sr-only">Loading...</span>
            </div>
        </button>
        <button
            v-if="save"
            class="btn dashbaricon"
            @click.prevent="savePositions"
            title="Save Skilltree positions"
            v-bind="{isLoading}"
            :disabled="isLoading"
        >
            <i class="material-icons" v-if="isLoading == false">save</i>
            <div
                class="spinner-border"
                role="status"
                v-if="isLoading"
                style="width:24px; height:24px; margin-left:14px;"
            >
                <span class="sr-only">Loading...</span>
            </div>
        </button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isLoading: false,
            positions: {}
        };
    },
    props: ["tree", "save"],
    methods: {
        async savePositions() {
            this.isLoading = true;
            if (this.hasItems()) {
                this.positions = this.getStorage();
            }
            try {
                await axios
                    .post("/skilltrees/" + this.tree + "/pos", {
                        positions: this.positions
                    })
                    .then(function(response) {
                        console.log(response.status);
                    });
            } catch (error) {
                this.errors = error;
                console.log("error" + this.errors);
            }
            this.isLoading = false;
        },
        hasItems() {
            let test = false;
            try {
                test = localStorage.getItem([
                    "tree_" + this.tree + "_skill_" + 0
                ]);
            } catch {
                test = false;
            }
            return test != null ? true : false;
        },
        getStorage() {
            let temp = [];
            let needle = "tree_" + this.tree;
            Object.keys(localStorage).forEach(function(key) {
                if (key.includes(needle)) {
                    if (key.includes(needle)) {
                        temp.push({ [key]: localStorage.getItem(key) });
                    }
                }
            });

            return temp;
        },
        restorePositions() {
            this.isLoading = true;
            let needle = "tree_" + this.tree;
            Object.keys(localStorage).forEach(function(key) {
                if (key.includes(needle)) {
                    if (key.includes(needle)) {
                        localStorage.removeItem(key);
                    }
                }
            });
            location.reload();
        }
    }
};
</script>

<style>
</style>
