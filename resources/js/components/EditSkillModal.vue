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
                                    <label for="description">Description</label>
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
                            </form>
                        </div>
                        <!--                        <div class="col-lg-6">
                            <form
                                @submit.prevent="submit"
                                @keydown="form.errorClear($event.target.name)"
                                id="tasksform"
                            >
                                <div class="form-group">
                                    <label>Tasks</label>
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
                                        v-for="(task, index) in form.skill_tasks"
                                    >
                                        <input
                                            form="skillform"
                                            class="form-control"
                                            type="text"
                                            v-model="task.body"
                                            :placeholder="'Task ' + (index + 1)"
                                            value="task.body"
                                        />
                                        <div class="input-group-append">
                                            <button
                                                class="btn dashbaricon"
                                                type="button"
                                                v-if="task.id"
                                                @click="updateTask(index + 1)"
                                            >
                                                <i class="material-icons">edit</i>
                                            </button>
                                            <button
                                                class="btn dashbaricon"
                                                type="button"
                                                v-if="!task.id"
                                                @click="storeTask(index + 1)"
                                            >
                                                <i class="material-icons">add</i>
                                            </button>
                                            <button
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
                        </div>-->
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
            skilltree: 0,
            form: new Form({
                id: 0,
                name: "",
                description: "",
                tasks: [{}]
            })
        };
    },
    methods: {
        beforeOpen: function(event) {
            console.log(event);
            this.skilltree = event.params.skill.skilltree_id;
            this.form.id = event.params.skill.id;
            this.form.name = event.params.skill.name;
            this.form.description = event.params.skill.description;
            this.form.tasks = event.params.tasks;
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
            console.log(getCardData);
            Event.$emit("clearCon");
            Event.$emit("updatePosCon", JSON.stringify(getCardData));
            Event.$emit("savePosCon", this.form.id);
            // ls[this.form.id].connections = [];
            // localStorage.setItem(this.skilltree, JSON.stringify(ls));
            // jqSimpleConnect.repaintAll();
        },
        async deleteSkill() {
            console.log("delete skill");
            //            let ls = localStorage.getItem(this.skilltree);
        }
    }
};
</script>

<style>
</style>
