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
                @click.prevent="$modal.show('edit-skill', { tree: tree, skill_id: id,  skill_title: skill_title, skill_description: skill_description, skill_tasks: skill_tasks})"
                title="Edit Skill"
            >
                <i class="material-icons" style="font-size:1.25rem; line-height: 1.2">edit</i>
            </a>
        </div>
        <div class="card-body" v-if="skill_tasks || skill_description">
            <p v-if="skill_description" class="card-text">{{ skill_description }}</p>
            <ul v-if="skill_tasks" class="list-unstyled">
                <li class="list-item" :key="index" v-for="(task, index) in skill_tasks">
                    <small>{{ task.body }}</small>
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
            color: "#0de1ec",
            thickness: 1,
            draggableValue: {
                onPositionChange: this.onPosChanged,
                onDragEnd: this.onDragEnd,
                initialPosition: this.getPos()
            },
            storage: {
                position: {},
                connections: this.getCon()
            }
        };
        console.log(this.storage);
    },
    methods: {
        handler: function(e) {
            if (e.target.offsetParent.id.includes("skill")) {
                jqSimpleConnect.connect(this.$el, e.target.offsetParent, {
                    radius: this.thickness,
                    color: this.color
                });

                if (
                    !this.storage.connections.includes(
                        e.target.offsetParent.id
                    ) &&
                    "skill_" + this.id !== e.target.offsetParent.id
                ) {
                    this.storage.connections.push(e.target.offsetParent.id);
                }

                localStorage.setItem(
                    ["tree_" + this.tree + "_skill_" + this.id],
                    JSON.stringify(this.storage)
                );
            }
            // remove handler
            document.removeEventListener("click", this.handler, true);
        },
        createConnection: function() {
            document.addEventListener("click", this.handler, true);
        },
        hasItems() {
            let test = false;
            try {
                test = localStorage.getItem([
                    "tree_" + this.tree + "_skill_" + this.id
                ]);
            } catch {
                test = false;
            }
            return test != null ? true : false;
        },
        getCon() {
            if (this.hasItems()) {
                this.storage = JSON.parse(
                    localStorage.getItem([
                        "tree_" + this.tree + "_skill_" + this.id
                    ])
                );
            } else {
                this.storage.connections = [];
            }
            return this.storage.connections;
        },
        getPos() {
            console.log("when is a skillcard initiated");
            if (this.hasItems()) {
                this.storage = JSON.parse(
                    localStorage.getItem([
                        "tree_" + this.tree + "_skill_" + this.id
                    ])
                );
            } else {
                this.storage = {
                    position: {
                        left: this.random(200, window.innerWidth - 200),
                        top: this.random(200, window.innerWidth - 200)
                    }
                };
            }
            return this.storage.position;
        },
        onPosChanged: function(positionDiff, absolutePosition, event) {
            if (absolutePosition) {
                this.storage.position = absolutePosition;

                localStorage.setItem(
                    ["tree_" + this.tree + "_skill_" + this.id],
                    JSON.stringify(this.storage)
                );
            }
            jqSimpleConnect.repaintAll();
        },
        onDragEnd: function() {
            // make db call to save positions
            //this.saveStorage();
        },
        random: function(min, max) {
            return Math.floor(Math.random() * (max - min)) + min;
        },
        async saveStorage() {
            let message;
            try {
                message = await axios.post(
                    "/skilltrees/" + this.tree + "/skills/" + this.id + "/pos"
                ).data.message;
            } catch (error) {
                message = error.response;
            }
            console.log(message);
        }
    },
    mounted() {
        if (typeof this.storage.connections !== "undefined") {
            this.storage.connections.forEach(e => {
                if (e) {
                    jqSimpleConnect.connect(
                        this.$el,
                        document.getElementById(e),
                        {
                            radius: this.thickness,
                            color: this.color
                        }
                    );
                }
            });
        }
    },
    props: ["tree", "id", "skill_title", "skill_description", "skill_tasks"]
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
