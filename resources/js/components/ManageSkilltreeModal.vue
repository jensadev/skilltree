<template>
    <modal name="manage-skilltree" classes="h-75">
        <div class="modal-body modal-content">
            <div class="container">
                <header class="row">
                    <div class="col-lg-12 text-center">
                        <h3 class="modal-title">Update skilltree</h3>
                    </div>
                </header>
                <div class="row">
                    <div class="col-lg-6">
                        <form>
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input id="title" name="title" class="form-control" type="text">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea
                                    id="description"
                                    name="description"
                                    class="form-control"
                                    rows="6"
                                ></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group d-flex justify-content-end">
                                <button
                                    type="button"
                                    class="btn btn-outline-primary mr-2"
                                    @click="$modal.hide('new-skilltree')"
                                >Cancel</button>
                                <button class="btn btn-primary" type="submit">Update Skilltree</button>
                            </div>
                        </form>
                        <slot></slot>
                    </div>
                    <div class="col-lg-6">GOOGLE STUFFINGS</div>
                </div>
            </div>
        </div>
    </modal>
</template>

<script>
export default {};
</script>

<style>
</style>
