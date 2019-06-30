<template>
    <modal
        name="manage-skilltree"
        classes="rounded"
        transition="nice-modal-fade"
        :adaptive="true"
        :scrollable="true"
        :reset="true"
        :pivot-y="0.25"
        :draggable="true"
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
                            <div class="form-group">
                                <div class="d-flex justify-content-end">
                                    <button
                                        type="button"
                                        class="btn btn-outline-primary mr-2"
                                        @click="$modal.hide('manage-skilltree')"
                                    >Cancel</button>
                                    <button
                                        class="btn btn-primary"
                                        type="submit"
                                        :disabled="form.errorAny()"
                                    >Update Skilltree</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-6">
                        <p>Google Classroom</p>
                        <div v-if="this.courses.length < 1">
                            <label for="load-classroom">Load courses from Google Classroom</label>
                            <button
                                class="btn dashbaricon"
                                id="load-classroom"
                                @click.prevent="getCourses"
                                v-bind="{isLoading}"
                            >
                                <i class="material-icons" v-if="isLoading == false">cloud_download</i>
                                <div
                                    class="spinner-border"
                                    role="status"
                                    v-if="isLoading"
                                    style="width:24px; height:24px; margin-left:14px;"
                                >
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </button>
                        </div>
                        <select
                            v-if="this.courses.length > 0"
                            class="form-control"
                            id="classroomid"
                            name="classroomid"
                        >
                            <option
                                v-for="(course, index) in courses"
                                :key="index"
                                :value="course.id"
                                v-text="course.descriptionHeading"
                            ></option>
                        </select>
                    </div>
                </div>
                <footer class="row">
                    <div class="col-lg-6"></div>
                    <div class="col-lg-6"></div>
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
            courses: [],
            form: new Form({
                title: this.title,
                description: this.description
            })
        };
    },
    props: ["id", "title", "description", "members"],
    methods: {
        async submit() {
            this.form
                .submit("/skilltrees/" + this.id, "patch")
                .then(response => (location = response.data.message))
                .catch(error => console.log(error));
        },
        async getCourses() {
            let courses;
            this.isLoading = true;
            await axios.get("/courses").then(function(response) {
                console.log(response);
                courses = response.data.message;
            });
            this.courses = courses;
            this.isLoading = false;
        }
    },
    computed: {}
};
</script>

