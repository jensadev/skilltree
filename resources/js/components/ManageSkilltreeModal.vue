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
        <div class="modal-body modal-content">
            <div class="container">
                <header class="row align-items-center">
                    <div class="col-lg-6">
                        <h3 class="modal-title">Manage skilltree</h3>
                    </div>
                    <div class="col-lg-6">
                        <div v-if="members" class="d-flex justify-content-end">
                            <img
                                v-for="(member, index) in members"
                                :key="index"
                                :src="member.avatar"
                                :alt="member.name"
                                title="User is allowed to edit Skilltree"
                                class="rounded-circle mr-1"
                                style="width: 24px;"
                            />
                        </div>
                    </div>
                </header>

                <div class="row">
                    <div class="col-lg-6">
                        <form
                            @submit.prevent="submit"
                            @keydown="form.errorClear($event.target.name)"
                            id="treeform"
                        >
                            <div class="form-group">
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
                                <label for="description">Description</label>
                                <textarea
                                    id="description"
                                    name="description"
                                    class="form-control"
                                    :class="form.errors.description ? 'is-invalid' : ''"
                                    rows="6"
                                    placeholder="Add a short description of your Skilltree"
                                    v-model="form.description"
                                    required
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
                        <form
                            @submit.prevent="connectCourse"
                            @keydown="form.errorClear($event.target.name)"
                        >
                            <div class="form-group">
                                <label for="courseId">Google Classroom</label>
                                <div
                                    v-if="this.courses.length < 1"
                                    class="d-flex align-items-center"
                                >
                                    <label for="load-courses">Load Courses from Google Classroom</label>
                                    <button
                                        class="btn dashbaricon"
                                        id="load-courses"
                                        @click.prevent="getCourses"
                                        v-bind="{isLoadingCourses}"
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
                                </div>
                                <select
                                    v-if="this.courses.length > 0"
                                    class="form-control"
                                    id="courseId"
                                    name="courseId"
                                    v-model="courseId"
                                >
                                    <option disabled value>Please select one</option>
                                    <option
                                        v-for="(course, index) in courses"
                                        :key="index"
                                        :value="course.id"
                                        v-text="course.descriptionHeading"
                                    ></option>
                                </select>
                            </div>
                            <button
                                v-if="this.courses.length > 0"
                                class="btn btn-primary"
                                type="submit"
                                :disabled="isConnectingCourse"
                                v-bind="{isConnectingCourse}"
                            >
                                Connect Course
                                <div
                                    class="spinner-border"
                                    role="status"
                                    v-if="isConnectingCourse"
                                    style="width:24px; height:24px; margin-left:14px;"
                                >
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </button>
                        </form>
                        <form
                            @submit.prevent="addTopics"
                            @keydown="form.errorClear($event.target.name)"
                        >
                            <div class="form-group">
                                <div
                                    v-if="this.courseId != 0 && this.topics.length < 1"
                                    class="d-flex align-items-center"
                                >
                                    <label for="load-topics">Load Topics from Google Classroom</label>
                                    <button
                                        class="btn dashbaricon"
                                        id="load-topics"
                                        @click.prevent="getTopics"
                                        v-bind="{isLoadingTopics}"
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
                                </div>
                                <select
                                    v-if="this.topics.length > 0"
                                    class="form-control"
                                    id="topicid"
                                    name="topicid"
                                    v-model="selectedTopics"
                                    multiple
                                >
                                    <option
                                        v-for="(topic, index) in topics"
                                        :key="index"
                                        :value="topic.name"
                                        v-text="topic.name"
                                    ></option>
                                </select>
                                <span>Selected: {{ selectedTopics }}</span>
                            </div>
                            <button
                                v-if="this.topics.length > 0"
                                class="btn btn-primary"
                                type="submit"
                                :disabled="form.errorAny()"
                            >Add Topics</button>
                        </form>
                    </div>
                </div>
                <footer class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <div class="d-flex justify-content-end">
                                <button
                                    type="button"
                                    class="btn btn-outline-primary mr-2"
                                    @click="$modal.hide('manage-skilltree')"
                                >Cancel</button>
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
                        </div>
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
        async addSkills() {},
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
        async getTopics() {
            let topics;
            this.isLoadingTopics = true;
            await axios
                .get("/classroom/topics/" + this.courseId)
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
            let temp = [];

            this.selectedTopics.forEach(topic => {
                temp.push({ skill_title: topic });
            });
            await axios
                .post("/skilltrees/" + this.id + "/classroom/topics", {
                    topics: temp
                })
                .then(function(response) {
                    location = response.data.message;
                })
                .catch(function(error) {
                    console.log(error);
                });
        }
    },
    computed: {}
};
</script>

