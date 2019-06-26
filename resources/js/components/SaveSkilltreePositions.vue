<template>
    <div class="save-skilltree-positions">
        <button
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
            load: this.loadPositions(),
            isLoading: false,
            positions: {}
        };
    },
    props: ["tree"],
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
        async loadPositions() {
            //if (!this.hasItems()) {
            this.isLoading = true;
            let needle = "tree_" + this.tree;
            await axios
                .get("/skilltrees/" + this.tree + "/pos")
                .then(function(response) {
                    let data = response.data.message.value;
                    console.log(response.status);
                    if (response.status == 200) {
                        data.forEach(element => {
                            //console.log(needle);
                            //console.log(element);
                            Object.keys(element).forEach(function(key) {
                                if (key.includes(needle)) {
                                    console.log(element[key]);
                                    localStorage.setItem(key, element[key]);
                                }
                            });
                        });
                    }
                })
                .catch(function(error) {
                    console.log(error);
                });
            //}
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
            //let storage = JSON.parse(localStorage);
            //console.log("storage");
            let temp = [];
            let needle = "tree_" + this.tree;
            Object.keys(localStorage).forEach(function(key) {
                if (key.includes(needle)) {
                    //temp.push(localStorage.getItem(key));
                    if (key.includes(needle)) {
                        temp.push({ [key]: localStorage.getItem(key) });
                    }
                }
            });

            return temp;

            // for (let i = 0; i < localStorage.length; i++) {
            //     console.log(localStorage.getItem(localStorage.key(i)));
            // }
        }
    },
    beforeMount() {
        // if (!this.hasItems) {
        //     this.loadPositions();
        // }
    }
};
</script>

<style>
</style>
