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
                    <div class="row">
                        <div class="col-lg-6">
                            <form
                                @submit.prevent="submit"
                                @keydown="form.errorClear($event.target.name)"
                                id="skillform"
                            >
                                <div class="form-group mb-3">
                                    <label for="name">Name</label>
                                    <input
                                        id="name"
                                        name="name"
                                        class="form-control"
                                        type="text"
                                        v-model="form.name"
                                        value="form.name"
                                        :class="form.errors.name ? 'is-invalid' : ''"
                                        required
                                    />
                                    <div
                                        class="invalid-feedback"
                                        v-if="form.errors.name"
                                        v-text="form.errors.name[0]"
                                    ></div>
                                </div>
                                <div class="form-group">
                                    <label for="description">
                                        Description
                                        <small class="text-muted">- optional</small>
                                    </label>
                                    <textarea
                                        id="description"
                                        name="description"
                                        class="form-control"
                                        rows="6"
                                        :class="form.errors.description ? 'is-invalid' : ''"
                                        v-model="form.description"
                                    >form.description</textarea>
                                    <div
                                        class="invalid-feedback"
                                        v-if="form.errors.description"
                                        v-text="form.errors.description[0]"
                                    ></div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="icon">
                                        Add
                                        <a
                                            target="_blank"
                                            href="https://material.io/tools/icons/?icon=extension&style=sharp"
                                        >Material Design</a>
                                        Icon
                                        <small
                                            class="text-muted"
                                        >- optional</small>
                                    </label>
                                    <input
                                        id="icon"
                                        name="icon"
                                        class="form-control"
                                        type="text"
                                        v-model="form.icon"
                                        value="form.icon"
                                        :class="form.errors.icon ? 'is-invalid' : ''"
                                        placeholder="Icon text name"
                                    />
                                    <div
                                        class="invalid-feedback"
                                        v-if="form.errors.icon"
                                        v-text="form.errors.icon[0]"
                                    ></div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6">
                            <form
                                @submit.prevent="submit"
                                @keydown="form.errorClear($event.target.name)"
                                id="tasksform"
                            >
                                <div class="form-group">
                                    <label>
                                        Tasks
                                        <small class="text-muted">- optional</small>
                                    </label>
                                    <div
                                        class="spinner-border text-muted"
                                        role="status"
                                        v-if="isLoadingCourseWork"
                                        style="width: 24px; height: 24px; margin-left:16px;"
                                    >
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <div
                                        class="input-group mb-3"
                                        :key="index"
                                        v-for="(task, index) in tasks"
                                    >
                                        <input
                                            form="tasksform"
                                            class="form-control"
                                            type="text"
                                            v-model="task.body"
                                            :placeholder="'Task ' + (index + 1)"
                                            value="task.body"
                                        />
                                        <input
                                            form="tasksform"
                                            class="form-control"
                                            type="text"
                                            v-model="task.link"
                                            placeholder="http://Url - optional"
                                            value="task.link"
                                        />
                                        <input
                                            hidden
                                            form="tasksform"
                                            type="text"
                                            v-if="task.id"
                                            v-model="task.id"
                                            value="task.id"
                                        />
                                        <div class="input-group-append">
                                            <button
                                                form="tasksform"
                                                class="btn dashbaricon"
                                                type="button"
                                                v-if="task.id"
                                                @click="updateTask(index + 1)"
                                            >
                                                <i class="material-icons">edit</i>
                                            </button>
                                            <button
                                                form="tasksform"
                                                class="btn dashbaricon"
                                                type="button"
                                                v-if="!task.id"
                                                @click="storeTask(index + 1)"
                                            >
                                                <i class="material-icons">save</i>
                                            </button>
                                            <button
                                                form="tasksform"
                                                class="btn dashbaricon"
                                                type="button"
                                                v-if="task.id"
                                                @click="deleteTask(index + 1)"
                                            >
                                                <i class="material-icons">delete</i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <a
                                        class="d-flex align-items-center border-0 bg-transparent"
                                        @click.prevent="addTask"
                                        href
                                    >
                                        <i class="material-icons">add_circle_outline</i>
                                        <small class="text-muted pl-2">Add a Task</small>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <footer class="modal-footer">
                        <button
                            class="btn btn-outline-secondary mr-2"
                            type="button"
                            @click="clearConnections"
                        >Clear Connections</button>
                        <button
                            class="btn btn-outline-danger mr-2"
                            type="button"
                            @click="deleteSkill"
                        >Delete Skill</button>
                        <button
                            form="skillform"
                            class="btn btn-primary"
                            type="submit"
                            :disabled="form.errorAny()"
                        >Update Skill</button>
                    </footer>
                </div>
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
            isLoadingCourseWork: false,
            skilltree: 0,
            tasks: [],
            form: new Form({
                id: 0,
                name: "",
                description: "",
                icon: "",
                courseId: 0,
                topicId: 0
            })
        };
    },
    // watch: {
    //     tasks: function() {
    //         window.events.$emit("updateTasks", JSON.stringify(this.tasks));
    //     }
    // },
    methods: {
        beforeOpen: function(event) {
            this.skilltree = event.params.skill.skilltree_id;
            this.form.id = event.params.skill.id;
            this.form.name = event.params.skill.name;
            this.form.description = event.params.skill.description;
            this.form.icon = event.params.skill.icon;

            if (event.params.tasks.length > 0) {
                this.tasks = event.params.tasks;
            } else {
                this.tasks = [{ body: "" }];
            }
        },
        clearConnections: function() {
            let ls = JSON.parse(localStorage.getItem(this.skilltree));
            ls[this.form.id].connections.forEach(element => {
                jqSimpleConnect.removeConnection(element.idstring);
            });

            let getCardData = {
                skilltree: this.skilltree,
                skill: this.form.id,
                position: ls[this.form.id].position,
                connections: []
            };
            window.events.$emit("clearCon");
            window.events.$emit("updatePosCon", JSON.stringify(getCardData));
            window.events.$emit("savePosCon", this.form.id);
        },
        async deleteSkill() {
            console.log("delete skill");
            this.isLoading = true;

            await axios
                .delete(
                    "/skilltrees/" + this.skilltree + "/skills/" + this.form.id
                )
                .then(function(response) {
                    //localStorage.removeItem(this.skilltree);
                    // needs to clear connections
                    location = response.data.message;
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        async submit() {
            // if (!this.form.tasks[0].body) {
            //     delete this.form.originalData.tasks;
            // }

            this.form
                .submit(
                    "/skilltrees/" + this.skilltree + /skills/ + this.form.id,
                    "patch"
                )
                .then(response => (location = response.data.message))
                .catch(function(error) {
                    flash({ body: error, type: "alert-danger" });
                });
        },
        addTask() {
            this.tasks.push({ body: "" });
        },
        async storeTask(task) {
            let update;
            console.log(this.tasks[task - 1]);
            await axios
                .post(
                    "/skilltrees/" +
                        this.skilltree +
                        "/skills/" +
                        this.form.id +
                        "/tasks/",
                    this.tasks[task - 1]
                )
                .then(function(response) {
                    update = response.data.message;
                    flash({ body: "Task Stored", type: "alert-success" });
                })
                .catch(function(error) {
                    flash({ body: error, type: "alert-danger" });
                });
            this.tasks.splice(task - 1, 1);
            this.tasks.push(update);
            //            this.tasks = _.sortBy(this.form.tasks, ["id", "body"]);
        },
        async updateTask(task) {
            let update;
            console.log(this.tasks[task - 1]);
            await axios
                .patch(
                    "/skilltrees/" +
                        this.skilltree +
                        "/skills/" +
                        this.form.id +
                        "/tasks/" +
                        this.tasks[task - 1].id,
                    this.tasks[task - 1]
                )
                .then(function(response) {
                    update = response.data.message;
                    flash({ body: "Task Updated", type: "alert-success" });
                })
                .catch(function(error) {
                    flash({ body: error, type: "alert-danger" });
                });
            this.tasks.splice(task - 1, 1);
            this.tasks.push(update);
            //            this.form.tasks = _.sortBy(this.form.tasks, ["id", "body"]);
        },
        async deleteTask(task) {
            await axios
                .delete(
                    "/skilltrees/" +
                        this.skilltree +
                        "/skills/" +
                        this.form.id +
                        "/tasks/" +
                        this.tasks[task - 1].id
                )
                .then(function(response) {
                    flash({ body: "Task Deleted", type: "alert-success" });
                })
                .catch(function(error) {
                    flash({ body: error, type: "alert-danger" });
                });
            await this.$nextTick(function() {
                this.tasks.splice(task - 1, 1);
                //                this.getCourseWork();
            });
        }
    }
};
</script>

<style>
</style>
