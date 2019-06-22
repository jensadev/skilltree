<template>
    <section class="dropzone" id="dropzone">
        <skillcard
            v-for="(skill, index) in skills"
            :key="index"
            :id="skill.id"
            :title="skill.title"
            :description="skill.description"
        ></skillcard>
    </section>
</template>
<script>
import skillcard from "./Skillcard.vue";
export default {
    name: "Skillzone",
    components: {
        skillcard
    },
    props: ["skills"],

    methods: {}
};
</script>
<style>
</style>


