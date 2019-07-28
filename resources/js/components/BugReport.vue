<template>
    <div class="bug-report">
        <button class="btn dashbaricon" role="button" title="Report a Bug" @click.prevent="hello">
            <i class="material-icons">bug_report</i>
        </button>
    </div>
</template>
<script>
export default {
    methods: {
        hello() {
            flash({
                body: "Keep calm and hit F5.",
                type: "alert-danger"
            });
        }
    }
};
</script>

<style>
</style>
