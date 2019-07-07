<template>
    <div class="card skill-card" :id="'skill_' + id" v-draggable="draggableValue">
        <div class="card-header d-flex justify-content-between">
            <h2
                class="h5 mb-0"
                v-text="$attrs.data.skill_title ? $attrs.data.skill_title.substr(0, 20) : $attrs.data.title.substr(0, 20)"
            ></h2>
            <a
                v-if="id != 0"
                href
                class="btn btn-less"
                style="padding: 0;"
                role="button"
                @click.prevent="$modal.show('edit-skill', { 
                    tree: tree, 
                    skill_id: id,  
                    skill_title: $attrs.data.skill_title, 
                    skill_description: $attrs.data.skill_description, 
                    skill_tasks: skill_tasks, 
                    skill_topicid: skill_topicid, 
                    skill_courseid: skill_courseid
                })"
                title="Edit Skill"
            >
                <i class="material-icons" style="font-size:1.25rem; line-height: 1.2">edit</i>
            </a>
        </div>
        <div class="card-body" v-if="$attrs.data.skill_description || $attrs.data.description">
            <nl2br
                tag="p"
                :text="$attrs.data.skill_description ? $attrs.data.skill_description.substr(0, 50) : $attrs.data.description.substr(0, 50)"
                class-name="card-text"
            />
        </div>
        <ul v-if="tasks" class="list-group list-group-flush">
            <li class="list-group-item" :key="index" v-for="(task, index) in tasks">
                <small>{{ task.body.substr(0, 25) }}</small>
            </li>
        </ul>

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
import Nl2br from "vue-nl2br";

export default {
    directives: {
        Draggable
    },
    components: {
        Nl2br
    },
    data() {
        return {
            init: this.loadInit(),
            color: "#0de1ec",
            thickness: 1,
            tasks: [],
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
    },
    methods: {
        async loadInit() {
            if (!this.hasItems() && this.id == 0) {
                let needle = "tree_" + this.tree;
                await axios
                    .get("/skilltrees/" + this.tree + "/pos")
                    .then(function(response) {
                        console.log(response.status);
                        if (response.status == 200) {
                            response.data.message.value.forEach(element => {
                                Object.keys(element).forEach(function(key) {
                                    localStorage.setItem(key, element[key]);
                                });
                            });
                        }
                    })
                    .then(function() {
                        location.reload();
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            }
        },
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
        }
    },
    mounted() {
        if (typeof this.storage.connections !== "undefined") {
            this.storage.connections.forEach(e => {
                if (e && document.getElementById(e)) {
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

        this.tasks = _.sortBy(this.skill_tasks, ["body"]);
    },
    props: ["tree", "id", "skill_tasks", "skill_topicid", "skill_courseid"]
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
