<template>
    <div class="invite-skilltree-member">
        <button
            class="btn dashbaricon"
            @click="isOpen = !isOpen"
            title="Invite another admin user to your Skilltree"
        >
            <i class="material-icons">share</i>
        </button>
        <div v-show="isOpen" class="smallform-content position-absolute w-50">
            <div class="card shadow-sm bg-white">
                <div class="card-body">
                    <form @submit.prevent="submit" @keydown="form.errorClear($event.target.name)">
                        <div class="input-group">
                            <input
                                id="email"
                                name="email"
                                type="text"
                                class="form-control"
                                placeholder="Email address"
                                aria-label="Email address"
                                :class="form.errors.email ? 'is-invalid' : ''"
                                v-model="form.email"
                                required
                            >
                            <div class="input-group-append">
                                <button
                                    class="btn btn-outline-primary"
                                    type="submit"
                                    :disabled="form.errorAny()"
                                >Invite</button>
                            </div>
                            <div
                                class="invalid-feedback"
                                v-if="form.errors.email"
                                v-text="form.errors.email[0]"
                            ></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Form from "./Form";

export default {
    data() {
        return {
            isOpen: false,
            form: new Form({
                email: ""
            })
        };
    },
    props: ["url"],
    watch: {
        isOpen() {
            if (this.isOpen) {
                document.addEventListener("click", this.closeIfClickedOutside);
                window.setTimeout(function() {
                    document.getElementById("email").focus();
                }, 0);
            }
        }
    },
    methods: {
        closeIfClickedOutside(event) {
            if (!this.$el.contains(event.target)) {
                this.isOpen = false;
                document.removeEventListener(
                    "click",
                    this.closeIfClickedOutside
                );
            }
        },
        async submit() {
            this.form
                .submit(this.url)
                .then(response => (location = response.data.message))
                .catch(error => console.log(error));
        }
    }
};
</script>