<template>
    <modal name="new-skilltree" classes="h-75">
        <div class="modal-body modal-content">
            <div class="container">
                <form @submit.prevent="submit" @keydown="form.errorClear($event.target.name)">
                    <header class="row">
                        <div class="col-lg-12 text-center">
                            <h3 class="modal-title">Create a new skilltree</h3>
                        </div>
                    </header>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input
                                    id="title"
                                    name="title"
                                    class="form-control"
                                    :class="form.errors.title ? 'is-invalid' : ''"
                                    type="text"
                                    v-model="form.title"
                                >
                                <div
                                    class="invalid-feedback"
                                    v-if="form.errors.title"
                                    v-text="form.errors.title[0]"
                                ></div>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea
                                    id="description"
                                    name="description"
                                    class="form-control"
                                    :class="form.errors.description ? 'is-invalid' : ''"
                                    rows="6"
                                    v-model="form.description"
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
                                <label>Add some skills</label>
                                <input
                                    class="form-control mb-2"
                                    type="text"
                                    :placeholder="'Skill ' + (index + 1)"
                                    v-for="(skill,index) in form.skills"
                                    v-model="skill.skill_title"
                                    :key="index"
                                >
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
                    <footer class="row">
                        <div class="col-lg-12">
                            <div class="form-group d-flex justify-content-end">
                                <button
                                    type="button"
                                    class="btn btn-outline-primary mr-2"
                                    @click="$modal.hide('new-skilltree')"
                                >Cancel</button>
                                <button
                                    class="btn btn-primary"
                                    type="submit"
                                    :disabled="form.errorAny()"
                                >Create Skilltree</button>
                            </div>
                        </div>
                    </footer>
                </form>
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
                skills: [{ skill_title: "" }]
            })
        };
    },
    methods: {
        addSkill() {
            this.form.skills.push({ skill_title: "" });
        },
        async submit() {
            if (!this.form.skills[0].skill_title) {
                delete this.form.originalData.skills;
            }

            this.form
                .submit("/skilltrees")
                .then(response => (location = response.data.message))
                .catch(error => console.log(error));
        }
    }
};
</script>

