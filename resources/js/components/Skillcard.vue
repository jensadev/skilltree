<template>
    <div class="card skillcard" v-bind:id="'skill_' + id" v-draggable="draggableValue">
        <div class="card-header">{{ title }}</div>
        <div class="card-body">
            <p class="card-text">{{ description }}</p>
        </div>
    </div>
</template>
<script>
import { Draggable } from "draggable-vue-directive";

export default {
    directives: {
        Draggable
    },
    data() {
        return {
            draggableValue: {
                onPositionChange: this.onPosChanged,
                onDragEnd: this.onDragEnd,
                initialPosition: this.getPos()
            },
            connected: [],
            lines: []
        };
    },
    methods: {
        getPos: function() {
            let pos = JSON.parse(localStorage.getItem("skill_" + this.id));
            if (pos) {
                return { left: pos[0], top: pos[1] };
            }
        },
        onPosChanged: function(positionDiff, absolutePosition, event) {
            if (absolutePosition) {
                localStorage.setItem(
                    "skill_" + this.id,
                    JSON.stringify([
                        absolutePosition.left,
                        absolutePosition.top
                    ])
                );
            }
        },
        onDragEnd: function() {
            console.log("stop");
        }
    },
    mounted() {},
    name: "skillcard",
    props: ["id", "title", "description"]
};
</script>
<style>
.line {
    position: absolute;
    border: 0.5px #00000010 dashed;
    z-index: -1;
}
</style>
