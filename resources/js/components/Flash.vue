<template>
    <div class="alert alert-dismissible fade show" :class="alertType" role="alert" v-show="show">
        {{ body }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</template>

<script>
import { setTimeout } from "timers";
export default {
    props: ["message"],
    data() {
        return {
            show: false,
            alertType: "",
            body: ""
        };
    },
    created() {
        window.events.$on("flash", message => {
            this.flash(message);
        });
    },
    methods: {
        flash(message) {
            (this.alertType = message.type ? message.type : "alert-primary"),
                (this.body = message.body);
            this.show = true;

            this.hide();
        },
        hide() {
            setTimeout(() => {
                this.show = false;
            }, 3000);
        }
    }
};
</script>

<style>
.alert {
    position: fixed;
    bottom: 1rem;
    left: 2%;
    width: 96%;
    z-index: 1100;
}
</style>
