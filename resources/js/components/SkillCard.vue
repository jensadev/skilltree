<template>
    <div class="card skill-card shadow-sm" :id="'skill_' + id" v-draggable="draggableValue">
        <div
            class="position-absolute text-light d-flex justify-content-center align-items-center h-100 w-100 card-bg"
            v-if="icon"
        >
            <i class="material-icons" style="font-size: 4rem;">{{ icon }}</i>
        </div>
        <div
            class="card-header d-flex justify-content-between align-items-end"
            style="padding-bottom: 0;"
        >
            <h2 class="h5">{{ str_limit(title, 15, true) }}</h2>
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
                <i class="material-icons" style="font-size:1.25rem; line-height: 1">edit</i>
            </a>
        </div>
        <div class="card-body">
            <p
                class="card-text mb-0"
                v-if="description"
                style="font-size: 90%;"
            >{{ str_limit(description, 45, true) }}</p>
            <ul v-if="tasks.length > 0" class="list-unstyled mb-0">
                <li class="list-item text-muted" :key="index" v-for="(task, index) in tasks">
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
    props: ["skilltree", "skill", "teacher"],
    data() {
        return {
            draggableValue: {
                onPositionChange: this.onPosChanged,
                onDragEnd: this.onDragEnd,
                initialPosition: { left: 0, top: 0 }
            },
            title: "",
            description: "",
            icon: "",
            id: "",
            tree: "",
            line: {
                color: "#0de1ec",
                thickness: 2
            },
            position: {},
            tasks: [],
            connections: [],
            path: ""
        };
    },
    created() {
        if (typeof this.skilltree !== "undefined") {
            this.title = this.skilltree.title;
            this.description = this.skilltree.description;
            this.id = 0;
            this.tree = this.skilltree.id;
        } else {
            this.title = this.skill.name;
            this.icon = this.skill.icon;
            this.description = this.skill.description
                ? this.skill.description
                : "";
            this.id = this.skill.id;
            this.tree = this.skill.skilltree_id;

            if (this.skill.tasks) this.tasks = this.skill.tasks;
        }

        this.draggableValue.initialPosition = this.getPos();

        window.events.$on("clearCon", data => {
            this.connections = [];
        });

        // window.events.$on("updateTasks", data => {
        //     this.tasks = JSON.parse(data);
        // });
    },
    mounted() {
        if (localStorage.hasOwnProperty(this.tree)) {
            let data = JSON.parse(localStorage.getItem(this.tree));

            if (data[this.id]) {
                if (
                    data[this.id] !== null &&
                    data[this.id].connections.length > 0
                ) {
                    this.connections = data[this.id].connections;
                    this.connections.forEach(connection => {
                        if (
                            connection.target &&
                            document.getElementById(connection.target)
                        ) {
                            connection.idstring = jqSimpleConnect.connect(
                                this.$el,
                                document.getElementById(connection.target),
                                {
                                    radius: this.line.thickness,
                                    color: this.line.color
                                }
                            );
                        }
                    });
                }
            }
        }
    },
    methods: {
        handler: function(e) {
            if (e.target.offsetParent.id.includes("skill")) {
                let con = jqSimpleConnect.connect(
                    this.$el,
                    e.target.offsetParent,
                    {
                        radius: this.line.thickness,
                        color: this.line.color
                    }
                );

                if (
                    _.find(this.connections, {
                        target: e.target.offsetParent.id
                    }) === undefined &&
                    "skill_" + this.id !== e.target.offsetParent.id
                ) {
                    this.connections.push({
                        idstring: con,
                        target: e.target.offsetParent.id
                    });
                }
            }
            window.events.$emit(
                "updatePosCon",
                JSON.stringify(this.getCardData())
            );
            window.events.$emit("savePosCon", this.id);

            document.removeEventListener("click", this.handler, true);
        },
        createConnection: function() {
            document.addEventListener("click", this.handler, true);
        },
        getCardData: function() {
            let posdata = {
                skilltree: this.tree,
                skill: this.id,
                position: this.position,
                connections: this.connections
            };
            return posdata;
        },
        onPosChanged: function(positionDiff, absolutePosition, event) {
            if (absolutePosition) {
                this.position = absolutePosition;

                window.events.$emit(
                    "updatePosCon",
                    JSON.stringify(this.getCardData())
                );
            }
            jqSimpleConnect.repaintAll();
        },
        onDragEnd: function(absolutePosition) {
            window.events.$emit("savePosCon", this.id);
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
            if (localStorage.hasOwnProperty(this.tree)) {
                let data = JSON.parse(localStorage.getItem(this.tree));
                if (data[this.id]) {
                    this.position = {
                        left: data[this.id].position.left,
                        top: data[this.id].position.top
                    };
                } else {
                    this.position = {
                        left: this.random(200, window.innerWidth - 200),
                        top: this.random(200, window.innerHeight - 200)
                    };
                }
            } else {
                this.position = {
                    left: this.random(200, window.innerWidth - 200),
                    top: this.random(200, window.innerHeight - 200)
                };
            }
            return this.position;
        }
    }
};
</script>

<style>
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
.card-bg {
    z-index: -1;
}
</style>

