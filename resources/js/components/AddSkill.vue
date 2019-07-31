<template>
    <li class="add-skill nav-item">
        <button
            class="nav-link btn dashbaricon"
            @click.prevent="isOpen = !isOpen"
            title="Add a new Skill"
        >
            <i class="material-icons">add_box</i>
        </button>
        <div v-show="isOpen" class="smallform-content position-absolute w-25">
            <div class="card shadow-sm bg-white">
                <div class="card-body">
                    <form @submit.prevent="submit" @keydown="form.errorClear($event.target.name)">
                        <div class="input-group">
                            <input
                                id="add-skill-name"
                                type="text"
                                class="form-control"
                                placeholder="Skill Name"
                                :class="form.errors.name ? 'is-invalid' : ''"
                                v-model="form.name"
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
                                v-if="form.errors.name"
                                v-text="form.errors.name[0]"
                            ></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </li>
</template>

<script>
import Form from "./Form";

export default {
    data() {
        return {
            isOpen: false,
            form: new Form({
                name: ""
            })
        };
    },
    props: ["url"],
    watch: {
        isOpen() {
            if (this.isOpen) {
                document.addEventListener("click", this.closeIfClickedOutside);

                Vue.nextTick().then(function() {
                    document.getElementById("add-skill-name").focus();
                });
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
                .then(function(response) {
                    location = response.data.message;
                })
                .catch(error => console.log(error));
        }
    }
};
</script>
