<template>
    <div class="card skillcard" :id="'skill_' + id" v-draggable="draggableValue">
        <div class="card-header">{{ skill_title }}</div>
        <div class="card-body">
            <p class="card-text">{{ skill_description }}</p>
        </div>
        <button class="btn btn-less lArr hideArr" @click="createConnection">
            <i class="material-icons" style="transform: scaleX(-1);">forward</i>
        </button>
        <button class="btn btn-less rArr hideArr" @click="createConnection">
            <i class="material-icons">forward</i>
        </button>
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
            connections: []
        };
    },
    methods: {
        handler: function(e) {
            jqSimpleConnect.connect(
                document.getElementById("skill_" + this.id),
                e.path[1],
                {
                    radius: 2,
                    color: "#bbb"
                }
            );
            // remove handler
            document.removeEventListener("click", this.handler, true);

            this.connections.push(e.path[1].id);

            localStorage.setItem(
                "tree_" + this.tree + "_" + this.id,
                JSON.stringify(this.connections)
            );
        },
        createConnection: function() {
            document.addEventListener("click", this.handler, true);
        },
        getPos: function() {
            let pos = JSON.parse(localStorage.getItem("skill_" + this.id));
            if (pos) {
                return { left: pos[0], top: pos[1] };
            } else {
                return {
                    left: this.random(200, window.innerWidth - 300),
                    top: this.random(200, window.innerHeight - 300)
                };
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
            jqSimpleConnect.repaintAll();
        },
        onDragEnd: function() {
            // make db call to save positions
        },
        random: function(min, max) {
            return Math.floor(Math.random() * (max - min)) + min;
        }
    },
    mounted() {
        let temp = JSON.parse(
            localStorage.getItem("tree_" + this.tree + "_" + this.id)
        );
        if (temp) {
            this.connections = temp;
            this.connections.forEach(e => {
                if (e) {
                    jqSimpleConnect.connect(
                        document.getElementById("skill_" + this.id),
                        document.getElementById(e),
                        {
                            radius: 2,
                            color: "#bbb"
                        }
                    );
                }
            });
        }
    },
    name: "skillcard",
    props: ["id", "skill_title", "skill_description", "tree"]
};
</script>
<style>
.line {
    position: absolute;
    border: 0.5px #00000010 dashed;
    z-index: -1;
}

.skillcard:hover .hideArr {
    visibility: visible;
}

.hideArr {
    visibility: hidden;
}
.rArr {
    color: #bbb;
    position: absolute;
    top: 50%;
    right: -36px;
    transform: translate(0, -50%);
}
.lArr {
    color: #bbb;
    position: absolute;
    top: 50%;
    left: -36px;
    transform: translate(0, -50%);
}
</style>
