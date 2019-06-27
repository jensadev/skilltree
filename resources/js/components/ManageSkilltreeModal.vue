<template>
    <modal name="manage-skilltree" classes="h-75">
        <div class="modal-body modal-content">
            <div class="container">
                <form @submit.prevent="submit" @keydown="form.errorClear($event.target.name)">
                    <header class="row">
                        <div class="col-lg-12 text-center">
                            <h3 class="modal-title">Manage skilltree</h3>
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
                                    placeholder="e.g Design"
                                    v-model="form.title"
                                    required
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
                            <div class="form-group d-flex justify-content-end">
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
                        <div class="col-lg-6">GOOGLE CONTENTS</div>
                    </div>
                </form>
                <footer class="row">
                    <div class="col-lg-12">
                        <div v-if="members">
                            <img
                                v-for="(member, index) in members"
                                :key="index"
                                :src="member.avatar"
                                :alt="member.name"
                                class="rounded-circle mr-1"
                                style="width: 24px;"
                            >
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
        }
    }
};
</script>

