<template>
    <div class="save-skilltree-positions">
        <button
            class="btn dashbaricon"
            @click.prevent="clearPosCon"
            title="Clear Skilltree positions and connections"
        >
            <i class="material-icons">clear</i>
        </button>
        <button
            class="btn dashbaricon"
            @click.prevent="restorePosCon"
            title="Restore Skilltree positions and connections from Database"
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
            @click.prevent="savePosConDB"
            title="Save Skilltree positions and connections to Database"
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
            storage: {}
        };
    },
    props: ["tree", "save"],
    methods: {
        async savePosConDB() {
            this.isSaving = true;
            let ls = JSON.parse(localStorage.getItem(this.skilltree));
            if (!ls) {
                ls = {};
            }
            await axios
                .post("/skilltrees/" + this.skilltree + "/pos", {
                    data: ls
                })
                .then(function(response) {
                    if (response.status === 200) {
                        flash({
                            body: response.data.message,
                            type: "alert-success"
                        });
                    }
                })
                .catch(function(error) {
                    flash({ body: error, type: "alert-danger" });
                });
            this.isSaving = false;
        },
        clearPosCon: function() {
            this.storage = {};
            localStorage.removeItem(this.skilltree);
            jqSimpleConnect.removeAll();
        },
        async restorePosCon() {
            this.isLoading = true;
            this.loadStorage(this.tree);
            this.isLoading = false;
        },
        setSkillStorage: function(data) {
            let posdata = JSON.parse(data);
            this.skilltree = posdata.skilltree;
            this.storage[posdata.skill] = {
                position: posdata.position,
                connections: posdata.connections
            };
        },
        saveSkillStorage: function(skill) {
            if (localStorage.getItem(this.skilltree) !== null) {
                let ls = JSON.parse(localStorage.getItem(this.skilltree));

                ls[skill] = this.storage[skill];

                this.storage = ls;
            }
            localStorage.setItem(this.skilltree, JSON.stringify(this.storage));
        },
        async loadStorage(id) {
            this.isLoading = true;
            await axios
                .get("/skilltrees/" + id + "/pos")
                .then(function(response) {
                    if (response.data.message != "No positions found") {
                        localStorage.setItem(
                            id,
                            JSON.stringify(response.data.message.value)
                        );
                        location.reload();
                    } else {
                        flash({
                            body: "No positions found.",
                            type: "alert-warning"
                        });
                    }
                })
                .catch(function(error) {
                    flash({ body: error, type: "alert-danger" });
                });
            this.isLoading = false;
        }
    },
    created: function() {
        window.events.$on("updatePosCon", data => {
            this.setSkillStorage(data);
        });
        window.events.$on("savePosCon", data => {
            this.saveSkillStorage(data);
        });

        if (localStorage.getItem(this.tree) === null) {
            this.loadStorage(this.tree);
        }
    }
};
</script>

<style>
</style>
