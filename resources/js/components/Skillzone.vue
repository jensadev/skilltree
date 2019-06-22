<template>
    <section>
        <skillcard :id="0" :title="title" :description="description" class="root"></skillcard>
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
    props: ["title", "description", "skills"],

    methods: {}
};
</script>
<style>
</style>


