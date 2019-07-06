<template>
    <modal
        name="manage-skilltree"
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
                    <h5 class="modal-title">Manage skilltree</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                        @click="$modal.hide('manage-skilltree')"
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
                                id="treeform"
                            >
                                <div class="form-group mb-3">
                                    <label for="title">Title</label>
                                    <input
                                        id="title"
                                        name="title"
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
                                    <label for="description">Notes</label>
                                    <textarea
                                        id="description"
                                        name="description"
                                        class="form-control"
                                        :class="form.errors.description ? 'is-invalid' : ''"
                                        rows="6"
                                        placeholder="Any notes you might need..."
                                        v-model="form.description"
                                    ></textarea>
                                    <div
                                        class="invalid-feedback"
                                        v-if="form.errors.description"
                                        v-text="form.errors.description[0]"
                                    ></div>
                                </div>
                            </form>
                        </div>

                        <div class="col-lg-6">
                            <label>
                                Connect with Google Classroom
                                <span
                                    v-if="this.courseId"
                                >- {{ this.courseId }}</span>
                            </label>
                            <form
                                @submit.prevent="connectCourse"
                                @keydown="form.errorClear($event.target.name)"
                            >
                                <div class="input-group mb-3">
                                    <select
                                        class="custom-select"
                                        id="courseId"
                                        name="courseId"
                                        v-model="courseId"
                                    >
                                        <option disabled selected>Load Courses from Classroom</option>
                                        <option
                                            v-for="(course, index) in courses"
                                            :key="index"
                                            :value="course.id"
                                            v-text="course.descriptionHeading"
                                        ></option>
                                    </select>
                                    <div class="input-group-append">
                                        <button
                                            v-if="this.courses.length < 1"
                                            class="btn dashbaricon"
                                            id="load-courses"
                                            @click.prevent="getCourses"
                                            v-bind="{isLoadingCourses}"
                                            title="Load Courses from Google Classroom"
                                        >
                                            <i
                                                class="material-icons"
                                                v-if="isLoadingCourses == false"
                                            >cloud_download</i>
                                            <div
                                                class="spinner-border"
                                                role="status"
                                                v-if="isLoadingCourses"
                                                style="width: 30px; height: 30px; margin-left: 8px;"
                                            >
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </button>
                                        <button
                                            v-if="this.courses.length > 0"
                                            class="btn dashbaricon"
                                            type="submit"
                                            :disabled="isConnectingCourse"
                                            v-bind="{isConnectingCourse}"
                                            title="Connect Google Classroom Course to Skilltree"
                                        >
                                            <i
                                                class="material-icons"
                                                v-if="isConnectingCourse == false"
                                            >link</i>
                                            <div
                                                class="spinner-border"
                                                role="status"
                                                v-if="isConnectingCourse"
                                                style="width:24px; height:24px; margin-left:14px;"
                                            >
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <form
                                @submit.prevent="addTopics"
                                @keydown="form.errorClear($event.target.name)"
                            >
                                <div class="input-group mb-3" v-if="this.courseId != 0">
                                    <select
                                        class="custom-select"
                                        id="topicid"
                                        name="topicid"
                                        v-model="selectedTopics"
                                        multiple
                                        :size="this.topics.length"
                                        style="overflow-y: auto;"
                                    >
                                        <option
                                            disabled
                                            selected
                                            v-if="this.topics.length < 1"
                                        >Load Topics from Course</option>
                                        <option
                                            v-for="(topic, index) in topics"
                                            :key="index"
                                            :value="[courseId, topic.topicId, topic.name]"
                                            v-text="topic.name"
                                        ></option>
                                    </select>
                                    <div class="input-group-append">
                                        <button
                                            v-if="this.topics.length < 1"
                                            class="btn dashbaricon"
                                            id="load-topics"
                                            @click.prevent="getTopics"
                                            v-bind="{isLoadingTopics}"
                                            title="Load Topics from Google Classroom"
                                        >
                                            <i
                                                class="material-icons"
                                                v-if="isLoadingTopics == false"
                                            >cloud_download</i>
                                            <div
                                                class="spinner-border"
                                                role="status"
                                                v-if="isLoadingTopics"
                                                style="width: 30px; height: 30px; margin-left: 8px;"
                                            >
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </button>
                                        <button
                                            v-if="this.topics.length > 0"
                                            class="btn dashbaricon"
                                            type="submit"
                                            :disabled="form.errorAny()"
                                            title="Add Topics as Skills to Skilltree"
                                        >
                                            <i class="material-icons">add</i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <footer class="modal-footer justify-content-between">
                    <div v-if="members">
                        <img
                            v-for="(member, index) in members"
                            :key="index"
                            :src="member.avatar"
                            :alt="member.name"
                            title="User member.name is allowed to edit Skilltree"
                            data-toggle="tooltip"
                            data-placement="bottom"
                            class="rounded-circle mr-1"
                            style="width: 24px;"
                        />
                    </div>
                    <div>
                        <button
                            class="btn btn-outline-secondary mr-2"
                            type="button"
                            @click="clearConnections"
                        >Clear Connections</button>
                        <button
                            class="btn btn-outline-danger mr-2"
                            type="button"
                            @click="deleteSkilltree"
                        >Delete Skilltree</button>
                        <button
                            form="treeform"
                            class="btn btn-primary"
                            type="submit"
                            :disabled="form.errorAny()"
                        >Update Skilltree</button>
                    </div>
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
            isLoadingCourses: false,
            isLoadingTopics: false,
            isConnectingCourse: false,
            courses: [],
            topics: [],
            courseId: this.cId,
            selectedTopics: [],
            form: new Form({
                title: this.title,
                description: this.description
            })
        };
    },
    props: ["id", "title", "description", "members", "cId"],
    methods: {
        async deleteSkilltree() {
            let needle = "tree_" + this.id;
            try {
                await axios
                    .delete("/skilltrees/" + this.id)
                    .then(function(response) {
                        if (response.status == 200) {
                            Object.keys(localStorage).forEach(function(key) {
                                if (key.includes(needle)) {
                                    localStorage.removeItem(key);
                                }
                            });
                        }
                        location = response.data.message;
                    });
            } catch (error) {
                this.errors = error;
                console.log("error" + this.errors);
            }
        },
        async submit() {
            this.form
                .submit("/skilltrees/" + this.id, "patch")
                .then(response => (location = response.data.message))
                .catch(error => console.log(error));
        },
        async getCourses() {
            let courses;
            this.isLoadingCourses = true;
            await axios
                .get("/classroom/courses")
                .then(function(response) {
                    courses = response.data.message;
                })
                .catch(function(error) {
                    console.log(error);
                });
            this.courses = courses;
            this.isLoadingCourses = false;
        },
        clearConnections() {
            let temp = JSON.parse(
                localStorage.getItem("tree_" + this.id + "_skill_0")
            );
            console.log(temp.connections);
            temp.connections = [];
            localStorage.removeItem("tree_" + this.id + "_skill_0");
            localStorage.setItem(
                "tree_" + this.id + "_skill_0",
                JSON.stringify(temp)
            );
            location = self.location;
        },
        async getTopics() {
            let topics;
            this.isLoadingTopics = true;
            await axios
                .get("/classroom/course/" + this.courseId + "/topics")
                .then(function(response) {
                    topics = response.data.message;
                })
                .catch(function(error) {
                    console.log(error);
                });
            this.topics = topics;
            this.isLoadingTopics = false;
        },
        async connectCourse() {
            this.isConnectingCourse = true;
            await axios
                .post("/skilltrees/" + this.id + "/classroom/course", {
                    courseId: this.courseId
                })
                .then(function(response) {
                    console.log(response.data.message);
                })
                .catch(function(error) {
                    console.log(error);
                });
            this.isConnectingCourse = false;
        },
        async addTopics() {
            await axios
                .post("/skilltrees/" + this.id + "/classroom/topics", {
                    topics: this.selectedTopics
                })
                .then(function(response) {
                    location = response.data.message;
                })
                .catch(function(error) {
                    console.log(error);
                });
        }
    }
};
</script>

