<template>
    <div
        class="card skill-card shadow-sm"
        :id="'skill_' + id"
        v-bind:style="{ left: position.left, top: position.top }"
    >
        <div
            class="position-absolute text-light d-flex justify-content-center align-items-center h-100 w-100 card-bg"
            v-if="icon"
        >
            <i class="material-icons" style="font-size: 3rem;">{{ icon }}</i>
        </div>
        <div
            class="card-header d-flex justify-content-between align-items-end"
            style="padding-bottom: 0;"
        >
            <h2 class="h5">{{ str_limit(title, 15, true) }}</h2>
        </div>
        <div class="card-body">
            <p
                class="card-text mb-0"
                v-if="description"
                style="font-size: 90%;"
            >{{ str_limit(description, 35, true) }}</p>
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
                v-bind:style="{ width: completed }"
                aria-valuenow="0"
                aria-valuemin="0"
                aria-valuemax="100"
            ></div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["skilltree", "skill"],
    data() {
        return {
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
            completed: ""
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
    },
    mounted() {
        if (this.id == 0 && !sessionStorage.hasOwnProperty(this.tree)) {
            window.events.$emit("studentLoad", this.tree);
        }

        if (sessionStorage.hasOwnProperty(this.tree)) {
            let data = JSON.parse(sessionStorage.getItem(this.tree));

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
        this.getPos();

        this.$el.style.top = this.position.top;
        this.$el.style.left = this.position.left;

        jqSimpleConnect.repaintAll();
    },
    methods: {
        random: function(min, max) {
            return Math.floor(Math.random() * (max - min)) + min;
        },
        str_limit: function(text, count, end) {
            return (
                text.slice(0, count) + (text.length > count && end ? "..." : "")
            );
        },
        getPos: function() {
            if (sessionStorage.hasOwnProperty(this.tree)) {
                let data = JSON.parse(sessionStorage.getItem(this.tree));

                if (data[this.id]) {
                    this.position = {
                        left: data[this.id].position.left + "px",
                        top: data[this.id].position.top + "px"
                    };
                } else {
                    this.position = {
                        left: this.random(200, window.innerWidth - 200) + "px",
                        top: this.random(200, window.innerWidth - 200) + "px"
                    };
                }
            } else {
                this.position = {
                    left: this.random(200, window.innerWidth - 200) + "px",
                    top: this.random(200, window.innerWidth - 200) + "px"
                };
            }
            return this.position;
        }
    }
};
</script>

<style>
.card-bg {
    z-index: -1;
}
</style>

