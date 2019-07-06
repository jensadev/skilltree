<template>
    <div class="add-skill">
        <button class="btn dashbaricon" @click.prevent="isOpen = !isOpen" title="Add a new Skill">
            <i class="material-icons">add_box</i>
        </button>
        <div v-show="isOpen" class="smallform-content position-absolute w-50">
            <div class="card shadow-sm bg-white">
                <div class="card-body">
                    <form @submit.prevent="submit" @keydown="form.errorClear($event.target.name)">
                        <div class="input-group">
                            <input
                                type="text"
                                name="skill_title"
                                id="skill_title"
                                class="form-control"
                                placeholder="Skill title"
                                aria-label="Skill title"
                                :class="form.errors.skill_title ? 'is-invalid' : ''"
                                v-model="form.skill_title"
                                required
                            />
                            <div class="input-group-append">
                                <button
                                    class="btn btn-outline-secondary"
                                    type="submit"
                                    :disabled="form.errorAny()"
                                >Add skill</button>
                            </div>
                            <div
                                class="invalid-feedback"
                                v-if="form.errors.skill_title"
                                v-text="form.errors.skill_title[0]"
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

                window.setTimeout(function() {
                    document.getElementById("skill_title").focus();
                }, 0);
            }
        }
    },
    methods: {
        closeIfClickedOutside(event) {
            if (!this.$el.contains(event.target)) {
                this.isOpen = false;
                document.removeEventListener(
                    "click",
                    this.closeIfClickedOutside
                );
            }
        },
        async submit() {
            this.form
                .submit(this.url)
                .then(response => (location = response.data.message))
                .catch(error => console.log(error));
        }
    }
};
</script>
