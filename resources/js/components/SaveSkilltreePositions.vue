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
            storage: {}
        };
    },
    props: ["tree", "skills"],
    methods: {
        async savePositions() {
            try {
                this.message = (await axios.patch(
                    "/skilltrees/" + this.tree + "/pos"
                )).data.message;
            } catch (error) {
                this.errors = error.response;
            }
        },
        async loadPositions() {
            console.log("load positions for " + this.tree);
        }
    },
    mounted() {
        this.loadPositions();

        // let storage = false;
        // try {
        //     storage = localStorage.getItem([
        //         "tree_" + this.tree + "_skill_" + this.id
        //         ]);
        //     } catch {
        //         con = false;
        //     }

        //     if (con != null) {
        //         this.storage = JSON.parse(
        //             localStorage.getItem([
        //                 "tree_" + this.tree + "_skill_" + this.id
        //             ])
        //         );
        //        this.submit();
    }
};
</script>

<style>
</style>
