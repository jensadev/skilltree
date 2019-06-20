<template>
  <div class="sc-container text-center" v-draggable="draggableValue" :style="style">
    <div class="card skillcard" v-bind:id="'skill_' + id">
      <div class="card-header">{{ title }}</div>
      <div class="card-body">
        <p class="card-text">{{ description }}</p>
      </div>
    </div>
    <button class="btn btn-less" @click="connect">
      <i class="material-icons">keyboard_arrow_down</i>
    </button>
  </div>
</template>
<script>
import { Draggable, DraggableValue } from "draggable-vue-directive";

export default {
  directives: {
    Draggable,
    DraggableValue
  },
  data() {
    return {
      draggableValue: {
        onPositionChange: this.onPosChanged,
        onDragEnd: this.onDragEnd
      },
      connected: [],
      lines: []
    };
  },
  methods: {
    connect: function() {
      console.log(this.id);
    },
    onPosChanged: function(positionDiff, absolutePosition, event) {
      if (absolutePosition) {
        localStorage.setItem(
          "skill_" + this.id,
          JSON.stringify([absolutePosition.left, absolutePosition.top])
        );
      }
    },
    onDragEnd: function() {
      console.log("stop");
    },
    random: function(min, max) {
      return Math.floor(Math.random() * (max - min)) + min;
    },
    createLines: function() {
      this.connected.forEach(line => {
        console.log(line);
        line.create();
      });
    },
    line: function(id, connected) {
      const line = {};
      line.id = "line_" + id;
      line.from = document.getElementById("skill_" + id); // dom element
      line.to = document.getElementById("skill_" + connected);
      line.create = function() {
        this.lineDiv = document.createElement("div");
        this.lineDiv.id = this.id;
        this.lineDiv.classList.add("line");
        document
          .getElementsByClassName("skilltree")[0]
          .appendChild(this.lineDiv);
        this.adjustLine();
      };
      line.adjustLine = function() {
        // // https://stackoverflow.com/questions/19382872/how-to-connect-html-divs-with-lines
        let fT = this.from.offsetTop + this.from.offsetHeight / 2;
        let tT = this.to.offsetTop + this.to.offsetHeight / 2;
        let fL = this.from.offsetLeft + this.from.offsetWidth / 2;
        let tL = this.to.offsetLeft + this.to.offsetWidth / 2;

        let CA = Math.abs(tT - fT);
        let CO = Math.abs(tL - fL);
        let H = Math.sqrt(CA * CA + CO * CO);
        let ANG = (180 / Math.PI) * Math.acos(CA / H);

        let top, left;

        if (tT > fT) {
          top = (tT - fT) / 2 + fT;
        } else {
          top = (fT - tT) / 2 + tT;
        }
        if (tL > fL) {
          left = (tL - fL) / 2 + fL;
        } else {
          left = (fL - tL) / 2 + tL;
        }

        if (
          (fT < tT && fL < tL) ||
          (tT < fT && tL < fL) ||
          (fT > tT && fL > tL) ||
          (tT > fT && tL > fL)
        ) {
          ANG *= -1;
        }
        top -= H / 2;

        this.lineDiv.style["-webkit-transform"] = "rotate(" + ANG + "deg)";
        this.lineDiv.style["-moz-transform"] = "rotate(" + ANG + "deg)";
        this.lineDiv.style["-ms-transform"] = "rotate(" + ANG + "deg)";
        this.lineDiv.style["-o-transform"] = "rotate(" + ANG + "deg)";
        this.lineDiv.style["-transform"] = "rotate(" + ANG + "deg)";
        this.lineDiv.style.top = top + "px";
        this.lineDiv.style.left = left + "px";
        this.lineDiv.style.height = H + "px";
      };
      return line;
    }
  },
  mounted() {
    this.createLines();
  },
  computed: {
    style() {
      let left = this.random(200, window.innerHeight - 200);
      let top = this.random(200, window.innerHeight - 200);
      let pos = JSON.parse(localStorage.getItem("skill_" + this.id));
      if (pos) {
        left = pos[0];
        top = pos[1];
      }
      return "left: " + left + "px; top: " + top + "px;";
    }
  },
  name: "skillcard",
  props: ["id", "title", "description"]
};
</script>
<style>
.sc-container {
  position: absolute;
  z-index: 35;
}
.skillcard {
  width: 18rem;
  text-align: left;
}
.line {
  position: absolute;
  border: 0.5px #00000010 dashed;
  z-index: -1;
}
#tracker {
  background-color: red;
}
</style>
