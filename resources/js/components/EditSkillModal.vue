<template>
    <modal name="edit-skill" classes="h-75" @before-open="beforeOpen">
        <div class="modal-body modal-content">
            <div class="container">
                <header class="row">
                    <div class="col-lg-12 text-center">
                        <h3 class="modal-title">Edit skill</h3>
                    </div>
                </header>
                <form @submit.prevent="submit" @keydown="form.errorClear($event.target.name)">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="skill_title">Title</label>
                                <input
                                    id="skill_title"
                                    name="skill_title"
                                    class="form-control"
                                    type="text"
                                    v-model="form.skill_title"
                                    value="form.skill_title"
                                    :class="form.errors.skill_title ? 'is-invalid' : ''"
                                    required
                                >
                                <div
                                    class="invalid-feedback"
                                    v-if="form.errors.skill_title"
                                    v-text="form.errors.skill_title[0]"
                                ></div>
                            </div>
                            <div class="form-group">
                                <label for="skill_description">Description</label>
                                <textarea
                                    id="skill_description"
                                    name="skill_description"
                                    class="form-control"
                                    rows="6"
                                    :class="form.errors.skill_description ? 'is-invalid' : ''"
                                    v-model="form.skill_description"
                                >form.skill_description</textarea>
                                <div
                                    class="invalid-feedback"
                                    v-if="form.errors.skill_description"
                                    v-text="form.errors.skill_description[0]"
                                ></div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Tasks</label>
                                <div
                                    class="input-group"
                                    :key="index"
                                    v-for="(task, index) in form.skill_tasks"
                                >
                                    <input
                                        class="form-control mb-2"
                                        type="text"
                                        v-model="task.body"
                                        :placeholder="'Task ' + (index + 1)"
                                        value="task.body"
                                    >
                                    <!--                                <div class="input-group-append">
                                        <select class="custom-select" id="inputGroupSelect02">
                                            <option selected>Value...</option>
                                            <option v-for="i in index" :key="task_value" value="i"></option>
                                        </select>
                                    </div>
                                    -->
                                </div>
                            </div>
                            <div class="form-group">
                                <a
                                    class="d-flex align-items-center border-0 bg-transparent"
                                    @click.prevent="addTask"
                                    href
                                >
                                    <i class="material-icons">add_circle_outline</i>
                                    <small class="text-muted pl-2">Add a Task</small>
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
                                    @click="$modal.hide('edit-skill')"
                                >Cancel</button>
                                <button
                                    class="btn btn-primary"
                                    type="submit"
                                    :disabled="form.errorAny()"
                                >Update Skill</button>
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
            tree: 0,
            form: new Form({
                skill_id: 0,
                skill_title: "",
                skill_description: "",
                skill_tasks: [{ body: "" }]
            })
        };
    },
    methods: {
        beforeOpen(event) {
            this.tree = event.params.tree;
            this.form.skill_id = event.params.skill_id;
            this.form.skill_title = event.params.skill_title;
            this.form.skill_description = event.params.skill_description;

            if (event.params.skill_tasks) {
                this.form.skill_tasks = event.params.skill_tasks;
            } else {
                this.form.skill_tasks = [{ body: "" }];
            }
        },
        addTask() {
            this.form.skill_tasks.push({ body: "" });
        },
        async submit() {
            if (!this.form.skill_tasks[0].body) {
                delete this.form.originalData.skill_tasks;
            }

            this.form
                .submit(
                    "/skilltrees/" + this.tree + /skills/ + this.form.skill_id,
                    "patch"
                )
                .then(response => (location = response.data.message))
                .catch(error => console.log(error));
        }
    }
};
</script>

<style>
</style>
