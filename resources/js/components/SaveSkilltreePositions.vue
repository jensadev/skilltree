<template>
    <div class="save-skilltree-positions">
        <button
            class="btn dashbaricon"
            @click.prevent="savePositions"
            title="Save Skilltree positions"
        >
            <i class="material-icons">save</i>
        </button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            message: "",
            errors: "",
            positions: {}
        };
    },
    props: ["tree"],
    methods: {
        async savePositions() {
            if (this.hasItems()) {
                this.positions = this.getStorage();
            }
            try {
                this.message = (await axios.post(
                    "/skilltrees/" + this.tree + "/pos",
                    {
                        positions: this.positions()
                    }
                )).data.message;
                console.log(this.message);
            } catch (error) {
                this.errors = error.response;
                console.log(this.errors);
            }
        },
        async loadPositions() {
            try {
                this.message = (await axios.get(
                    "/skilltrees/" + this.tree + "/pos"
                )).data.message;
                console.log(this.message);
            } catch (error) {
                this.errors = error.response;
                console.log(this.errors);
            }
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
            //let storage = JSON.parse(localStorage);
            //console.log("storage");
            let storage = [];
            let needle = "tree_" + this.tree;
            Object.keys(localStorage).forEach(function(key) {
                if (key.includes(needle)) {
                    console.log(localStorage.getItem(key));
                    storage.push(localStorage.getItem(key));
                }
            });

            return storage;

            // for (let i = 0; i < localStorage.length; i++) {
            //     console.log(localStorage.getItem(localStorage.key(i)));
            // }
        }
    },
    beforeMount() {
        this.loadPositions();
    }
};
</script>

<style>
</style>
