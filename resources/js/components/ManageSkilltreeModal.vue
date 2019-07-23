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
                <header class="modal-header pb-0 align-items-baseline">
                    <ul
                        class="nav nav-tabs"
                        id="mangeTab"
                        role="tablist"
                        style="border-bottom: 0px;"
                    >
                        <li class="nav-item">
                            <a
                                class="nav-link active"
                                id="information-tab"
                                href="#information"
                                data-toggle="tab"
                                role="tab"
                                aria-controls="information"
                                aria-selected="true"
                            >Information</a>
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                id="classroom-tab"
                                href="#classroom"
                                data-toggle="tab"
                                role="tab"
                                aria-controls="classroom"
                                aria-selected="true"
                            >Classroom</a>
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                id="students-tab"
                                href="#students"
                                data-toggle="tab"
                                role="tab"
                                aria-controls="students"
                                aria-selected="true"
                            >Students</a>
                        </li>
                    </ul>
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
                    <div class="tab-content" id="informationTabContent">
                        <div
                            class="tab-pane fade show active"
                            id="information"
                            role="tabpanel"
                            aria-labelledby="information-tab"
                        >
                            <form
                                @submit.prevent="submit"
                                @keydown="form.errorClear($event.target.name)"
                                id="treeform"
                            >
                                <div class="col-lg-12">
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

                                    <div class="row">
                                        <div class="col-lg-6">
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
                                                <label for="notes">Teacher Notes</label>
                                                <textarea
                                                    id="notes"
                                                    name="notes"
                                                    class="form-control"
                                                    :class="form.errors.notes ? 'is-invalid' : ''"
                                                    rows="6"
                                                    v-model="form.notes"
                                                    placeholder="Only visible to Teachers"
                                                ></textarea>
                                                <div
                                                    class="invalid-feedback"
                                                    v-if="form.errors.notes"
                                                    v-text="form.errors.notes[0]"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div
                            class="tab-pane fade"
                            id="classroom"
                            role="tabpanel"
                            aria-labelledby="classroom-tab"
                        >
                            <div class="col-lg-12 mb-3">
                                <h5 class="modal-title">Google Classroom</h5>
                            </div>
                            <!-- <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <form
                                            @submit.prevent="connectCourse"
                                            @keydown="form.errorClear($event.target.name)"
                                        >
                                            <div class="input-group mb-3">
                                                <select
                                                    class="custom-select"
                                                    id="course_id"
                                                    name="course_id"
                                                    v-model="courseId"
                                                >
                                                    <option disabled selected>Please select one</option>
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
                                                        v-if="!isConnected"
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
                                                    <button
                                                        v-if="isConnected"
                                                        class="btn dashbaricon"
                                                        id="disconnectBtn"
                                                        type="button"
                                                        @click="deleteCourseConnection"
                                                        title="Disconnect Google Classroom Course from Skilltree"
                                                    >
                                                        <i class="material-icons">link_off</i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                                                <div v-if="isConnected" class="d-flex justify-content-between align-items-center">
                                            <label for="inviteStudentsBtn" class="mb-0">Invite Students from Course</label>
                                            <button
                                                class="btn dashbaricon"
                                                id="inviteStudentsBtn"
                                                type="button"
                                                @click="inviteStudents"
                                            >
                                                <i class="material-icons">group_add</i>
                                            </button>
                                        </div>
                            -->
                            <!-- </div>
                                    <div class="col-lg-6" v-if="isConnected">
                                        <form
                                            @submit.prevent="addTopics"
                                            @keydown="form.errorClear($event.target.name)"
                                        >
                                            <label
                                                for="topicsBtn"
                                                v-text="this.topics.length < 1 ? 'Load Topics from selected Course' : 'Create Skills from Topics'"
                                            ></label>
                                            <div class="input-group mb-3">
                                                <select
                                                    class="custom-select"
                                                    id="topic_id"
                                                    name="topic_id"
                                                    v-model="selectedTopics"
                                                    multiple
                                                    :size="this.topics.length"
                                                    style="overflow-y: auto;"
                                                >
                                                    <option
                                                        v-for="(topic, index) in topics"
                                                        :key="index"
                                                        :value="[couresId, topic.topic_id, topic.name]"
                                                        v-text="topic.name"
                                                    ></option>
                                                </select>
                                                <div class="input-group-append">
                                                    <button
                                                        v-if="this.topics.length < 1"
                                                        class="btn dashbaricon"
                                                        id="topicsBtn"
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
                                                        id="topicsBtn"
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
                            </div>-->
                        </div>
                        <div
                            class="tab-pane fade"
                            id="students"
                            role="tabpanel"
                            aria-labelledby="students-tab"
                        >
                            <h5>Students Tab</h5>
                            <form @submit.prevent="addStudents" id="studentForm">
                                <textarea
                                    name="studentEmails"
                                    id="studentEmails"
                                    class="form-control"
                                    cols="30"
                                    rows="10"
                                    v-model="studentEmails"
                                ></textarea>
                                <button class="btn btn-secondary mr-2" type="submit">
                                    Add Students
                                    <div
                                        class="spinner-border"
                                        role="status"
                                        v-if="isAddingStudents"
                                        style="width:24px; height:24px; margin-left:14px;"
                                    >
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <footer class="modal-footer justify-content-between">
                    <div class="d-flex">
                        <img
                            :src="skilltree.owner.avatar"
                            :alt="skilltree.owner.name"
                            :title="'Skilltree owner, ' + skilltree.owner.name + ''"
                            data-toggle="tooltip"
                            data-placement="bottom"
                            class="rounded-circle mr-1 border border-info"
                            style="width: 24px;"
                        />
                        <div v-if="members">
                            <img
                                v-for="(member, index) in members"
                                :key="index"
                                :src="member.avatar"
                                :alt="member.name"
                                :title="'User ' + member.name + ' is allowed to edit Skilltree'"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                class="rounded-circle mr-1"
                                style="width: 24px;"
                            />
                        </div>
                    </div>
                    <div>
                        <!-- <button
                            class="btn btn-outline-secondary mr-2"
                            type="button"
                            @click="clearConnections"
                        >Clear Connections</button>-->
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
            isAddingStudents: false,
            isLoadingCourses: false,
            isLoadingTopics: false,
            isConnectingCourse: false,
            courses: [],
            topics: [],
            selectedTopics: [],
            isConnected: false,
            id: this.skilltree.id,
            studentEmails: "",
            form: new Form({
                title: this.skilltree.title,
                description: this.skilltree.description,
                notes: this.skilltree.notes,
                courseId: this.skilltree.course_id
            })
        };
    },
    props: ["skilltree", "members"],
    methods: {
        // async deleteCourseConnection() {
        //     let con = true;
        //     await axios
        //         .delete("/skilltrees/" + this.id + "/classroom/course")
        //         .then(function(response) {
        //             console.log(response.data.message);
        //             con = false;
        //         })
        //         .catch(function(error) {
        //             console.log(error);
        //         });
        //     this.isConnected = con;
        //     this.courseId = 0;
        // },
        async deleteSkilltree() {
            let id = this.id;
            await axios
                .delete("/skilltrees/" + this.id)
                .then(function(response) {
                    localStorage.removeItem(id);
                    location = response.data.message;
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        async submit() {
            this.form
                .submit("/skilltrees/" + this.id, "patch")
                .then(function(response) {
                    location = response.data.message;
                })
                .catch(error => console.log(error));
        },
        async addStudents() {
            console.log(this.studentEmails);
            await axios
                .put("/skilltrees/" + this.id + "/students", this.studentEmails)
                .then(function(response) {
                    console.log(response);
                })
                .catch(function(error) {
                    console.log(error);
                });
        }
        // async getCourses() {
        //     let courses;
        //     this.isLoadingCourses = true;
        //     Event.$emit("onCenterLoading");
        //     await axios
        //         .get("/classroom/courses")
        //         .then(function(response) {
        //             courses = response.data.message;
        //         })
        //         .catch(function(error) {
        //             console.log(error.response);
        //             if (
        //                 error.response.data.exception ==
        //                 "Google_Service_Exception"
        //             ) {
        //                 axios.post("/logout").then(function() {
        //                     location = "/login";
        //                 });
        //             }
        //         });
        //     this.courses = courses;
        //     this.isLoadingCourses = false;
        //     Event.$emit("onCenterLoading");
        // },
        // clearConnections() {
        //     let temp = JSON.parse(
        //         localStorage.getItem("tree_" + this.id + "_skill_0")
        //     );
        //     console.log(temp.connections);
        //     temp.connections = [];
        //     localStorage.removeItem("tree_" + this.id + "_skill_0");
        //     localStorage.setItem(
        //         "tree_" + this.id + "_skill_0",
        //         JSON.stringify(temp)
        //     );
        //     //location = self.location;
        //     jqSimpleConnect.repaintAll();
        // },
        // async getTopics() {
        //     let topics;
        //     this.isLoadingTopics = true;
        //     await axios
        //         .get("/classroom/courses/" + this.courseId + "/topics")
        //         .then(function(response) {
        //             topics = response.data.message;
        //         })
        //         .catch(function(error) {
        //             console.log(error);
        //         });
        //     this.topics = topics;
        //     this.isLoadingTopics = false;
        // },
        // async connectCourse() {
        //     this.isConnectingCourse = true;
        //     let con = false;
        //     await axios
        //         .post("/skilltrees/" + this.id + "/classroom/course", {
        //             course_id: this.courseId
        //         })
        //         .then(function(response) {
        //             console.log(response.data.message);
        //             con = true;
        //         })
        //         .catch(function(error) {
        //             console.log(error);
        //         });
        //     this.isConnected = con;
        //     this.isConnectingCourse = false;
        //     this.getTopics();
        // },
        // async addTopics() {
        //     await axios
        //         .post("/skilltrees/" + this.id + "/classroom/topics", {
        //             topics: this.selectedTopics
        //         })
        //         .then(function(response) {
        //             console.log(response.data.message);
        //             //location = response.data.message;
        //         })
        //         .catch(function(error) {
        //             console.log(error);
        //         });
        // },
    },
    mounted() {
        // this.getCourses();
        // this.$nextTick(() => {
        //     if (this.courseId != 0) this.isConnected = true;
        // });
    }
};
</script>

