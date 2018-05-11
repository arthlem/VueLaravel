<template>
    <v-container>
        <h1>Toutes les idées</h1>
    
        <v-container grid-list-xl>
            
            <v-layout justify-center wrap>
                <v-flex xs6 md4 v-for="idea in ideas" v-bind:key="idea.id">
                    <v-card>
                        <v-card-media :src="idea.image_link" height="200px">
                        </v-card-media>
                        <v-card-title primary-title>
                            <div>
                                <h3 class="headline mb-0">{{idea.name}}</h3>
                                <div>{{idea.description}}</div>
                                <v-container grid-list-xl>
                                    <v-layout justify-center wrap>
                                        <v-chip v-for="i in [0,1,2,3]" v-bind:key="i">Example Chip {{i}}</v-chip>
                                    </v-layout>
                                </v-container>
                            </div>
                        </v-card-title>
                        <v-card-actions>
                            <v-btn flat color="orange">Plus de details</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
        <v-speed-dial fixed v-model="fab" :top="top" :bottom="bottom" :right="right" :left="left" :direction="direction" :open-on-hover="hover" :transition="transition">
            <v-btn slot="activator" color="blue darken-2" dark fab hover v-model="fab">
                <v-icon>menu</v-icon>
                <v-icon>close</v-icon>
            </v-btn>
             <v-btn fab dark small color="indigo" :to="{ name: 'CreateIdea' }">
                <v-icon>add</v-icon>
            </v-btn>
            <v-btn fab dark small color="green">
                <v-icon>edit</v-icon>
            </v-btn>
            <v-btn fab dark small color="red">
                <v-icon>delete</v-icon>
            </v-btn>
        </v-speed-dial>
    </v-container>
</template>

<script>
    export default {
        data() {
            return {
                headers: [{
                        text: "Nom",
                        align: "left",
                        value: "name"
                    },
                    {
                        text: "Image",
                        value: "image_link"
                    },
                    {
                        text: "Creator Id",
                        value: "id_creator"
                    }
                ],
                ideas: [],
                direction: "top",
                fab: false,
                fling: false,
                hover: true,
                tabs: null,
                top: false,
                right: true,
                bottom: true,
                left: false,
                transition: "slide-y-reverse-transition"
            };
        },
        created: function() {
            this.fetchItems();
        },
        methods: {
            fetchItems() {
                let uri = "http://localhost:8000/ideas";
                this.axios.get(uri).then(response => {
                    this.ideas = response.data;
                });
            },
            deleteItem(id) {
                let uri = `http://localhost:8000/idea/${id}`;
                this.ideas.splice(id, 1);
                this.axios.delete(uri);
            }
        }
    };
</script>