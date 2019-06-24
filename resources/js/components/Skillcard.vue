<template>
    <div class="card skillcard" :id="'skill_' + id" v-draggable="draggableValue">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="h5">{{ skill_title }}</h2>
            <a
                v-if="id != 0"
                href
                class="btn btn-less"
                style="padding: 0;"
                role="button"
                @click.prevent="$modal.show('edit-skill')"
                title="Edit Skill"
            >
                <i class="material-icons" style="font-size:1.25rem; line-height: 1.2">edit</i>
            </a>
        </div>
        <div class="card-body">
            <p class="card-text">{{ skill_description }}</p>
        </div>

        <div v-if="id != 0" class="progress" style="height: 5px;">
            <div
                class="progress-bar bg-pink"
                role="progressbar"
                style="width: 25%"
                aria-valuenow="25"
                aria-valuemin="0"
                aria-valuemax="100"
            ></div>
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
                    radius: 1,
                    color: "#dd0890"
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
                            radius: 1,
                            color: "#dd0890;"
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
