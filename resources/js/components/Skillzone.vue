<template>
  <section>
    <div
      class="card skillcard"
      draggable="true"
      v-for="(skill, index) in skilltree"
      v-bind:id="'skill_'+skill.id"
      :key="index"
    >
      <div class="card-header">{{ skill.title }}</div>
      <div class="card-body">Content</div>
    </div>
    <div>
      <p>
        {{ cards }}
        {{ lines }}
      </p>
    </div>
  </section>
</template>
<script>
export default {
  data() {
    return {
      cards: [],
      lines: []
    };
  },
  props: ["skilltree"],
  methods: {
    createLine() {}
  }
};
</script>
