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
        <!--v-if="save"-->
        <button
            class="btn dashbaricon"
            @click.prevent="savePositions"
            title="Save Skilltree positions"
            v-bind="{isSaving}"
            :disabled="isSaving"
        >
            <i class="material-icons" v-if="isSaving == false">save</i>
            <div
                class="spinner-border"
                role="status"
                v-if="isSaving"
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
            isSaving: false,
            skilltree: 0,
            storage: []
        };
    },
    props: ["tree", "save"],
    methods: {
        async savePositions() {
            this.isSaving = true;
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
            this.isSaving = false;
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
                    temp.push({ [key]: localStorage.getItem(key) });
                }
            });

            return temp;
        },
        restorePositions() {
            this.isLoading = true;
            let needle = "tree_" + this.tree;
            Object.keys(localStorage).forEach(function(key) {
                if (key.includes(needle)) {
                    localStorage.removeItem(key);
                }
            });
            //location.reload();
        }
    },
    methods: {
        //setSkillStorage: _.debounce(function(data) {
        setSkillStorage: function(data) {
            let posdata = JSON.parse(data);
            this.skilltree = posdata.skilltree;
            this.storage[posdata.skill] = {
                position: posdata.position,
                connections: posdata.connections
            };
            //}, 500),
        },
        //saveSkillStorage: _.debounce(function() {
        saveSkillStorage: function() {
            localStorage.setItem(
                [this.skilltree],
                JSON.stringify(this.storage)
            );
        }
        //}, 500)
    },
    created: function() {
        Event.$on("setPosCon", data => {
            this.setSkillStorage(data);
        });
        Event.$on("savePosCon", data => {
            this.saveSkillStorage(data);
        });
    }
};
</script>

<style>
</style>
