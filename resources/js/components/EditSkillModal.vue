<template>
    <modal
        name="edit-skill"
        classes="rounded"
        transition="nice-modal-fade"
        :adaptive="true"
        :reset="true"
        :pivot-y="0.25"
        width="60%"
        height="auto"
        @before-open="beforeOpen"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <header class="modal-header">
                    <h5 class="modal-title">Edit skill</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                        @click="$modal.hide('edit-skill')"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </header>
                <div class="modal-body">
                    <form
                        @submit.prevent="submit"
                        @keydown="form.errorClear($event.target.name)"
                        id="skillform"
                    >
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
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
                                    />
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
                                        class="input-group mb-3"
                                        :key="index"
                                        v-for="(task, index) in form.skill_tasks"
                                    >
                                        <input
                                            class="form-control mb-2"
                                            type="text"
                                            v-model="task.body"
                                            :placeholder="'Task ' + (index + 1)"
                                            value="task.body"
                                        />
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
                    </form>
                </div>
                <footer class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-outline-primary mr-2"
                        @click="$modal.hide('edit-skill')"
                    >Cancel</button>
                    <button
                        class="btn btn-outline-danger mr-2"
                        type="button"
                        @click="deleteSkill"
                        v-bind="{isLoading}"
                        :disabled="isLoading"
                    >
                        Delete Skill
                        <div
                            class="spinner-border"
                            role="status"
                            v-if="isLoading"
                            style="width:24px; height:24px; margin-left:14px;"
                        >
                            <span class="sr-only">Loading...</span>
                        </div>
                    </button>
                    <button
                        form="skillform"
                        class="btn btn-primary"
                        type="submit"
                        :disabled="form.errorAny()"
                    >Update Skill</button>
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
            isLoading: false,
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
        async deleteSkill() {
            this.isLoading = true;
            let lsKey = "tree_" + this.tree + "_skill_" + this.form.skill_id;
            let skillNeedle = "skill_" + this.form.skill_id;
            let needle = "tree_" + this.tree;
            try {
                await axios
                    .delete(
                        "/skilltrees/" +
                            this.tree +
                            "/skills/" +
                            this.form.skill_id
                    )
                    .then(function(response) {
                        localStorage.removeItem(lsKey);
                        // needs to clear connections
                        location = response.data.message;
                    });
            } catch (error) {
                this.errors = error;
                console.log("error" + this.errors);
            }
            this.isLoading = false;
        },
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
