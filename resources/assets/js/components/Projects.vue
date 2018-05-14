<template>
    <v-layout>
        <v-toolbar color="primary" flat dark fixed>
            <v-toolbar-title>Tous les projets</v-toolbar-title>
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
            <v-progress-linear v-if="loading" :indeterminate="true"></v-progress-linear>
            <v-layout justify-center wrap>
                <v-flex xs12 md4 v-for="project in projects" v-bind:key="project.id">
                    <v-card>
                        <v-card-media :src="project.image_link" height="200px">
                        </v-card-media>
                        <v-card-title primary-title>
                            <v-layout justify-start align-center>
                                <h3 class="headline mb-0">{{project.name}}</h3>
                                <v-spacer></v-spacer>
                                <v-btn v-if="user.id == project.id_creator" icon ripple @click.stop="initUpdate(project)">
                                    <v-icon>create</v-icon>
                                </v-btn>
                                <v-btn v-if="user.id == project.id_creator" icon ripple @click="deleteProject(project.id)">
                                    <v-icon color="red">delete</v-icon>
                                </v-btn>
                            </v-layout>
                        </v-card-title>
                        <v-card-actions>
                            <v-btn :to="{  name: 'ProjectDetails' , params: { projectId: project.id }}" flat color="orange">Voir les idées proposées</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
        <v-dialog v-model="createDialog" fullscreen hide-overlay transition="dialog-bottom-transition" scrollable>
            <v-card tile>
                <v-toolbar card dark color="primary">
                    <v-btn icon dark @click.native="createDialog = false">
                        <v-icon>close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Ajouter un projet</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <v-btn dark flat @click.native="addProject">Ajouter le project</v-btn>
                    </v-toolbar-items>
    
                </v-toolbar>
                <v-card-text>
                    <v-layout justify-center align-center>
                        <v-flex xs12 md10>
                            <v-form>
                                <v-text-field label="Nom" v-model="newProject.name" :counter="50" required></v-text-field>
                                <v-text-field label="Lien de l'image" v-model="newProject.image_link" required></v-text-field>
                            </v-form>
                        </v-flex>
                    </v-layout>
                </v-card-text>
            </v-card>
        </v-dialog>
        <v-dialog v-model="showUpdateDialog" fullscreen hide-overlay transition="dialog-bottom-transition" scrollable>
            <v-card tile>
                <v-toolbar card dark color="primary">
                    <v-btn icon dark @click.native="showUpdateDialog = false">
                        <v-icon>close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Modifier un projet</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <v-btn dark flat @click.native="updateProject">Sauver le project</v-btn>
                    </v-toolbar-items>
    
                </v-toolbar>
                <v-card-text>
                    <v-layout justify-center align-center>
                        <v-flex xs12 md10>
                            <v-form>
                                <v-text-field label="Nom" v-model="projectToUpdate.name" :counter="50" required></v-text-field>
                                <v-text-field label="Lien de l'image" v-model="projectToUpdate.image_link" required></v-text-field>
                            </v-form>
                        </v-flex>
                    </v-layout>
                </v-card-text>
            </v-card>
        </v-dialog>
        <v-btn color="blue darken-2" hover dark fab fixed bottom right @click="createDialog = true">
            <v-icon>add</v-icon>
        </v-btn>
    </v-layout>
</template>

<script>
    export default {
        data() {
            return {
                createDialog: false,
                showUpdateDialog: false,
                loading: true,
                projects: [],
                user: {},
                newProject: {},
                projectToUpdate: {}
            };
        },
        created: function() {
            this.fetchProjects();
            this.user = this.$auth.user();
        },
        methods: {
            fetchProjects() {
                let uri = "http://localhost:8000/api/projects";
                this.axios.get(uri).then(response => {
                    this.projects = response.data;
                    if (this.projects.length == 0) {
                        console.log("empty");
                    }
                    this.loading = false;
                });
            },
            initUpdate(project) {
                this.projectToUpdate = project;
                this.showUpdateDialog = true;
            },
            updateProject() {
                this.showUpdateDialog = false;
                var id = this.projectToUpdate.id;
                let uri = `http://localhost:8000/api/projects/${id}`;
                let index = this.projects.map(item => item.id).indexOf(id);
                this.projects[index] = this.projectToUpdate;
                this.axios.put(uri, this.projectToUpdate).then(response => {
                    console.log(response);
                });
            },
            deleteProject(id) {
                let uri = `http://localhost:8000/api/projects/${id}`;
                let index = this.projects.map(item => item.id).indexOf(id);
                this.projects.splice(index, 1);
                this.axios.delete(uri);
            },
            addProject() {
                let uri = "http://localhost:8000/api/projects";
                this.createDialog = false
                this.axios
                    .post(uri, {
                        name: this.newProject.name,
                        image_link: this.newProject.image_link,
                        id_creator: this.user.id
                    })
                    .then(response => {
                        this.projects.push(response.data)
                    });
            }
        }
    };
</script>

<style scoped>
    .margin_top {
        margin-top: 70px;
    }
</style>
