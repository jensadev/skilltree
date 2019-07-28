<template>
    <modal
        name="new-skilltree"
        classes="rounded"
        transition="nice-modal-fade"
        :adaptive="true"
        :reset="true"
        :pivot-y="0.25"
        width="60%"
        height="auto"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <header class="modal-header">
                    <h5 class="modal-title">Create a new skilltree</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                        @click="$modal.hide('new-skilltree')"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </header>
                <div class="modal-body">
                    <form
                        @submit.prevent="submit"
                        @keydown="form.errorClear($event.target.name)"
                        id="skilltreeform"
                    >
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input
                                        class="form-control"
                                        :class="form.errors.title ? 'is-invalid' : ''"
                                        type="text"
                                        placeholder="e.g Design"
                                        v-model="form.title"
                                        required
                                    />
                                    <div
                                        class="invalid-feedback"
                                        v-if="form.errors.title"
                                        v-text="form.errors.title[0]"
                                    ></div>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea
                                        class="form-control"
                                        :class="form.errors.description ? 'is-invalid' : ''"
                                        rows="6"
                                        v-model="form.description"
                                        placeholder="Description of Skilltree..."
                                    ></textarea>
                                    <div
                                        class="invalid-feedback"
                                        v-if="form.errors.description"
                                        v-text="form.errors.description[0]"
                                    ></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Add Skills</label>
                                    <input
                                        class="form-control mb-2"
                                        type="text"
                                        :placeholder="'Skill ' + (index + 1)"
                                        v-for="(skill,index) in form.skills"
                                        v-model="skill.name"
                                        :key="index"
                                    />
                                </div>
                                <div class="form-group">
                                    <a
                                        class="d-flex align-items-center border-0 bg-transparent"
                                        @click.prevent="addSkill"
                                        href
                                    >
                                        <i class="material-icons">add_circle_outline</i>
                                        <small class="text-muted pl-2">Add a new skill field</small>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <footer class="modal-footer">
                    <button
                        form="skilltreeform"
                        class="btn btn-primary"
                        type="submit"
                        :disabled="form.errorAny()"
                    >Create Skilltree</button>
                </footer>
            </div>
        </div>
    </modal>
</template>
<script>
import Form from "./Form";

export default {
    data() {
        return {
            form: new Form({
                title: "",
                description: "",
                skills: [{ name: "" }]
            })
        };
    },
    methods: {
        addSkill() {
            this.form.skills.push({ name: "" });
        },
        async submit() {
            if (!this.form.skills[0].name) {
                delete this.form.originalData.skills;
            }

            this.form
                .submit("/skilltrees")
                .then(response => (location = response.data.message))
                .catch(function(error) {
                    flash({ body: error, type: "alert-danger" });
                });
        }
    }
};
</script>

