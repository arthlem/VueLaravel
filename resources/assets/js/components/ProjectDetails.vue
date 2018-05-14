<template>
    <v-layout>
        <v-toolbar color="primary" flat dark fixed>
            <v-btn flat to="/"><v-icon>keyboard_backspace</v-icon></v-btn>
            <v-toolbar-title>Toutes les idées du projet</v-toolbar-title>
            <v-spacer></v-spacer>
    
            <v-toolbar-items>
    
                <v-btn flat :to="{ name: 'login' }" v-if="!$auth.check()">
                    Login
                </v-btn>
                <v-btn flat :to="{ name: 'register' }" v-if="!$auth.check()">Register
                </v-btn>
                <v-btn flat v-if="$auth.check()" class="pull-right" @click.prevent="$auth.logout()">
                    Logout
                </v-btn>
            </v-toolbar-items>
    
        </v-toolbar>
        <v-container grid-list-xl class="margin_top">
            <v-layout row align-center wrap>
                <v-flex xs12 md8>
                    <v-text-field id="idea_text" v-model="idea.text" label="Idea"></v-text-field>
                </v-flex>
                <v-flex xs12 md4 justify-end>
                    <v-btn color="primary" @click="addIdea">Ajouter une idée</v-btn>
                </v-flex>
            </v-layout>
    
            <v-alert @click="error = false" type="error" :value="error" transition="slide-y-transition" dismissible>
                {{errorMessage}}
                <v-btn v-if="!$auth.check()" :to="{ name: 'login' }" flat>Se connecter</v-btn>
            </v-alert>
            <v-progress-linear v-if="loading" :indeterminate="true"></v-progress-linear>
            <v-flex v-if="ideas.length == 0">
                <h3>Aucune idées pour l'instant</h3>
            </v-flex>
            <ul v-else class="list-group">
                <li v-for="idea in ideas" v-bind:key="idea.id" class="list-group-item">
                    <v-icon class="glyphicon" @click="upVote(idea)">keyboard_arrow_up</v-icon>
                    <span class="label label-primary">{{ idea.count | formatCount }}</span>
                    <v-icon class="glyphicon" @click="downVote(idea)">keyboard_arrow_down</v-icon>
                    <a>{{ idea.text }}</a>
                    <div v-if="isCreator(idea.id_creator)" class="actions">
                        <v-btn icon small ripple @click.stop="showUpdate(idea)">
                            <v-icon>create</v-icon>
                        </v-btn>
                        <v-btn icon small ripple @click="deleteIdea(idea)">
                            <v-icon color="red" @click="deleteIdea(idea)">delete</v-icon>
                        </v-btn>
                    </div>
                </li>
            </ul>
    
        </v-container>
        <v-dialog v-model="updateDialog" fullscreen hide-overlay transition="dialog-bottom-transition" scrollable>
            <v-card tile>
                <v-toolbar card dark color="primary">
                    <v-btn icon dark @click.native="updateDialog = false">
                        <v-icon>close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Modifier une idée</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <v-btn dark flat @click.native="update()">Sauver</v-btn>
                    </v-toolbar-items>
    
                </v-toolbar>
                <v-card-text>
                    <v-layout>
                        <v-flex>
                            <v-text-field id="idea_text" v-model="updatedIdea.text" label="Idea"></v-text-field>
                        </v-flex>
                    </v-layout>
                </v-card-text>
    
                <div style="flex: 1 1 auto;"></div>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
    export default {
        data() {
            return {
                ideas: [],
                error: false,
                errorMessage: '',
                user: null,
                loading: true,
                idea: {},
                updateDialog: false,
                updatedIdea: {},
            };
        },
        created() {
            this.fetchIdeas();
            this.user = this.$auth.user();
        },
        methods: {
            fetchIdeas() {
                let uri =
                    "http://localhost:8000/api/project/" +
                    this.$router.history.current.params.projectId +
                    "/ideas";
                this.axios.get(uri).then(response => {
                    this.ideas = response.data;
                    this.loading = false;
                });
            },
            showUpdate(idea) {
                this.updateDialog = true;
                this.updatedIdea = idea;
            },
            update() {
                this.updateDialog = false;
                let uri = `http://localhost:8000/api/ideas/${this.updatedIdea.id}`;
                this.axios.put(uri, {
                    text: this.updatedIdea.text
                }).then(response => {
                    console.log(response);
                });
            },
            deleteIdea(idea) {
                let uri = `http://localhost:8000/api/ideas/${idea.id}`;
                let index = this.ideas.map(item => item.id).indexOf(idea.id);
                this.ideas.splice(index, 1);
                this.axios.delete(uri);
            },
            displayNotification() {
                this.$snotify.success({
                    body: 'Success Body',
                    title: 'Success Title',
                    config: {}
                });
            },
            isCreator(id_creator) {
                if (this.user.id == id_creator) {
                    return true;
                }
                return false;
            },
            addIdea() {
                var idea = this.idea;
                let uri =
                    "http://localhost:8000/api/project/" +
                    this.$router.history.current.params.projectId +
                    "/ideas";
    
                idea.id_creator = this.user.id;
                idea.id_project = this.$router.history.current.params.projectId;
    
                this.axios.post(uri, idea).then(response => {
                    idea.id = response.data.id;
                    idea.count = 0;
                    this.ideas.push(idea);
                });
            },
            checkPermission(idea) {
                if (Object.keys(this.user).length !== 0) {
                    if (this.user.id != idea.id_creator) {
                        return true;
                    } else {
                        this.$snotify.error({
                            body: 'Vous ne pouvez pas voter pour vos propres idées',
                            title: 'Erreur',
                            config: {}
                        });
                        this.errorMessage = "Vous ne pouvez pas voter pour vos propres idées.";
                        this.error = true;
                        return false;
                    }
                } else {
                    this.errorMessage = "Vous devez être connecté pour voter.";
                    this.error = true;
                    return false;
                }
            },
            upVote(idea) {
                if (this.checkPermission(idea)) {
                    idea.count++;
                    this.sendVote(idea, 1);
                }
            },
            sendVote(idea, value) {
                var vote = {};
                let uri =
                    "http://localhost:8000/api/vote";
    
                vote.id_user = this.user.id;
                vote.id_idea = idea.id;
                vote.value = value;
    
                console.log(vote);
    
                this.axios.post(uri, vote).then(response => {
                    console.log(response);
                    this.displayNotification()
                });
            },
            downVote(idea) {
                if (this.checkPermission(idea)) {
                    idea.count--;
                    this.sendVote(idea, -1);
                }
            }
        }
    };
</script>

<style>
    a {
        padding-left: 5px;
    }
    
    .disabled {
        color: orange;
    }
    
    .glyphicon {
        opacity: 1;
        transition: opacity 0.25s ease-in-out;
        -moz-transition: opacity 0.25s ease-in-out;
        -webkit-transition: opacity 0.25s ease-in-out;
    }
    
    .glyphicon:hover {
        opacity: 0.75;
        cursor: pointer;
    }
    
    .list-group-item {
        position: relative;
        display: block;
        padding: 0.75rem 1.25rem;
        margin-bottom: -1px;
        background-color: #fff;
        border: 1px solid rgba(0, 0, 0, 0.125);
    }
    
    .list-group {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        padding-left: 0;
        margin-bottom: 0;
    }
    
    .actions {
        float: right;
    }

    .margin_top {
        margin-top: 70px;
    }
</style>


