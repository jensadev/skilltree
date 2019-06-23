<template>
    <section class="skillzone">
        <skillcard :id="0" :title="title" :description="description" :tree="tree" class="root"></skillcard>
        <skillcard
            v-for="(skill, index) in skills"
            :key="index"
            :tree="tree"
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
    props: ["title", "description", "skills", "tree"],

    methods: {}
};
</script>
<style>
.skillzone {
    height: 100vh;
}
</style>


