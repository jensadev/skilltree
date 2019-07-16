<template>
    <div class="card skill-card" :id="'skill_' + id" v-draggable="draggableValue">
        <div class="card-header d-flex justify-content-between">
            <h2 class="h5 mb-0">{{ str_limit(title, 17, true) }}</h2>
            <a
                v-if="id != 0"
                href="#"
                class="btn btn-less"
                style="padding: 0;"
                role="button"
                @click.prevent="$modal.show('edit-skill', { 
                    skill: skill,
                    tasks: tasks
                })"
                title="Edit Skill"
            >
                <i class="material-icons" style="font-size:1.25rem; line-height: 1.2">edit</i>
            </a>
        </div>
        <div class="card-body">
            <p class="card-text mb-0" v-if="description">{{ str_limit(description, 40, true) }}</p>
            <ul v-if="tasks.length > 0" class="list-unstyled mb-0 border-top">
                <li class="list-item" :key="index" v-for="(task, index) in tasks">
                    <small>{{ str_limit(task.body, 20, true) }}</small>
                </li>
            </ul>
        </div>

        <div v-if="id != 0" class="progress" style="height: 5px;">
            <div
                class="progress-bar bg-pink"
                role="progressbar"
                style="width: 0%"
                aria-valuenow="0"
                aria-valuemin="0"
                aria-valuemax="100"
            ></div>
        </div>

        <button
            class="btn btn-arr lArr hideArr"
            @click="createConnection"
            title="Click to connect to the next Skill you click on"
        >
            <i class="material-icons" style="transform: scaleX(-1);">forward</i>
        </button>
        <button
            class="btn btn-arr rArr hideArr"
            @click="createConnection"
            title="Click to connect to the next Skill you click on"
        >
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
    props: ["skilltree", "skill"],
    data() {
        return {
            draggableValue: {
                onPositionChange: this.onPosChanged,
                onDragEnd: this.onDragEnd,
                initialPosition: this.getPos()
            },
            title: "",
            description: "",
            id: "",
            tree: "",
            line: {
                color: "#0de1ec",
                thickness: 1
            },
            position: {},
            tasks: [],
            connections: [],
            path: ""
        };
    },
    beforeMount() {
        if (this.skill && this.skill.tasks) this.tasks = this.skill.tasks;

        if (typeof this.skilltree !== "undefined") {
            this.title = this.skilltree.title;
            this.description = this.skilltree.description;
            this.id = 0;
            this.tree = this.skilltree.id;
        } else {
            this.title = this.skill.name;
            this.description = this.skill.description
                ? this.skill.description
                : "";
            this.id = this.skill.id;
            this.tree = this.skill.skilltree_id;
        }
    },
    methods: {
        handler: function(e) {
            if (e.target.offsetParent.id.includes("skill")) {
                jqSimpleConnect.connect(this.$el, e.target.offsetParent, {
                    radius: this.line.thickness,
                    color: this.line.color
                });

                if (
                    !this.connections.includes(e.target.offsetParent.id) &&
                    "skill_" + this.id !== e.target.offsetParent.id
                ) {
                    this.connections.push(e.target.offsetParent.id);
                }
            }
            document.removeEventListener("click", this.handler, true);
        },
        createConnection: function() {
            document.addEventListener("click", this.handler, true);
        },
        onPosChanged: function(positionDiff, absolutePosition, event) {
            if (absolutePosition) {
                //                console.log(absolutePosition);
                this.position = absolutePosition;

                let posdata = {
                    skilltree: this.tree,
                    skill: this.id,
                    position: this.position,
                    connections: this.connections
                };

                Event.$emit("setPosCon", JSON.stringify(posdata));
            }
            jqSimpleConnect.repaintAll();
        },
        onDragEnd: function(absolutePosition) {
            Event.$emit("savePosCon");
        },
        random: function(min, max) {
            return Math.floor(Math.random() * (max - min)) + min;
        },
        str_limit: function(text, count, end) {
            return (
                text.slice(0, count) + (text.length > count && end ? "..." : "")
            );
        },
        getPos: function() {
            this.position = {
                left: this.random(200, window.innerWidth - 200),
                top: this.random(200, window.innerWidth - 200)
            };

            return this.position;
        }
    }
};
</script>

<style>
.line {
    position: absolute;
    border: 0.5px #00000010 dashed;
    z-index: -1;
}

.skill-card:hover .hideArr {
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

