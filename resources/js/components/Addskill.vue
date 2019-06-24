<template>
    <div class="addskill">
        <!-- trigger -->
        <button class="dashbaricon btn" @click="isOpen = !isOpen" title="Add a new Skill">
            <slot name="trigger"></slot>
        </button>
        <!-- content -->
        <div v-show="isOpen" class="addskill-content position-absolute w-50">
            <div class="card shadow-sm bg-white">
                <div class="card-body">
                    <form
                        method="post"
                        @submit.prevent="onSubmit"
                        @keydown="form.errors.clear($event.target.name)"
                    >
                        <div class="input-group">
                            <input
                                type="text"
                                name="skill_title"
                                id="skill_title"
                                class="form-control"
                                placeholder="Skill title"
                                aria-label="Skill title"
                                aria-describedby="button-title"
                                :class="form.errors.has('skill_title') ? 'is-invalid' : ''"
                                v-model="form.skill_title"
                            >
                            <div class="input-group-append">
                                <button
                                    class="btn btn-outline-secondary"
                                    type="submit"
                                    id="button-title"
                                    :disabled="form.errors.any()"
                                >Add skill</button>
                            </div>
                            <div
                                class="invalid-feedback"
                                v-if="form.errors.has('skill_title')"
                                v-text="form.errors.get('skill_title')"
                            ></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Form from "./Form";

export default {
    data() {
        return {
            isOpen: false,
            form: new Form({
                skill_title: ""
            })
        };
    },
    props: ["url"],
    watch: {
        isOpen() {
            if (this.isOpen) {
                document.addEventListener("click", this.closeIfClickedOutside);
                document.getElementById("skill_title").autofocus = true;
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
        },
        onSubmit: function() {
            this.form
                .post(this.url)
                .then(response => console.log("Wahoo!"))
                .catch(error =>
                    console.log(this.form.errors.get("skill_title"))
                );
        }
    }
};
</script>
<style>
.addskill-content {
    right: 15px;
}
</style>
