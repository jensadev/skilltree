<template>
    <section class="skillzone">
        <skillcard
            :id="0"
            :skill_title="title"
            :skill_description="description"
            :tree="tree"
            class="root"
        ></skillcard>
        <skillcard
            v-for="(skill, index) in skills"
            :key="index"
            :tree="tree"
            :id="skill.id"
            :skill_title="skill.skill_title"
            :skill_description="skill.skill_description"
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


