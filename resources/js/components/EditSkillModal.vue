<template>
    <modal name="edit-skill" classes="h-75">
        <div class="modal-body modal-content">
            <div class="container">
                <form @submit.prevent="submit">
                    <header class="row">
                        <div class="col-lg-12 text-center">
                            <h3 class="modal-title">Edit skill</h3>
                        </div>
                    </header>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="skill_title">Title</label>
                                <input
                                    id="skill_title"
                                    name="skill_title"
                                    class="form-control"
                                    type="text"
                                >
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="skill_description">Description</label>
                                <textarea
                                    id="skill_description"
                                    name="skill_description"
                                    class="form-control"
                                    rows="6"
                                ></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </modal>
</template>

<script>
import Form from "./Form";

export default {};
</script>

<style>
</style>
