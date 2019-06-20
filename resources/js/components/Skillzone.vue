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
import Skillcard from "./Skillcard.vue";
export default {
  name: "Skillzone",
  components: {
    Skillcard
  },
  props: ["skills"],
  data() {
    return {};
  },
  methods: {
    createLine: function() {},
    listeners: function() {
      let dragged;
      let zone = document.getElementById("dropzone");
      /* events fired on the draggable target */
      zone.addEventListener(
        "drag",
        function(e) {
          e.target.top = e.y + "px";
          e.target.left = e.x + "px";
          console.log(e.target.top);
        },
        false
      );

      zone.addEventListener(
        "dragstart",
        function(e) {
          // store a ref. on the dragged elem
          this.dragged = e.target;
          // make it half transparent
          e.target.style.opacity = 0.5;
        },
        false
      );

      zone.addEventListener(
        "dragend",
        function(e) {
          // reset the transparency
          e.target.style.opacity = "";
          e.target.style.top = e.target.top + "px";
          e.target.style.left = e.target.left + "px";
        },
        false
      );

      /* events fired on the drop targets */
      zone.addEventListener(
        "dragover",
        function(e) {
          // prevent default to allow drop
          e.preventDefault();
        },
        false
      );

      zone.addEventListener("dragenter", function(e) {}, false);

      zone.addEventListener("dragleave", function(e) {}, false);

      zone.addEventListener(
        "drop",
        function(e) {
          // prevent default action (open as link for some elements)
          e.preventDefault();
          console.log("drop");
          // move dragged elem to the selected drop target
          if (e.target.className == "dropzone") {
            console.log("fire");
            e.target.style.background = "";
            this.dragged.parentNode.removeChild(this.dragged);
            e.target.appendChild(this.dragged);
          }
        },
        false
      );
    }
  },
  mounted() {
    this.listeners();
  }
};
</script>

