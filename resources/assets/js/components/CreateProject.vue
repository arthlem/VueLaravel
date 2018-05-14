<template>
    <v-container>
        <h1>Add Project</h1>
    
        <v-form v-model="valid">
            <v-text-field label="Nom" v-model="project.name" :rules="nameRules" :counter="50" required></v-text-field>
            <v-text-field label="Lien de l'image" v-model="project.image_link" required></v-text-field>
        </v-form>
        <v-btn color="info" :disabled="!valid" @click="addProject">Add Project</v-btn>
    </v-container>
</template>

<script>
    export default {
        data() {
            return {
                valid: false,
                name: "",
                nameRules: [
                    v => !!v || "Le nom est requis",
                    v => v.length <= 50 || "Le nom doit faire moins 50 de caractères"
                ],
                image_link: "",
                project: {},
                user: {}
            };
        },
        created() {
            this.user = this.$auth.user();
        },
        methods: {
            addProject() {
                let uri = "http://localhost:8000/api/projects";
                this.project.id_creator = this.user.id;
                this.axios
                    .post(uri, project)
                    .then(response => {
                        this.$router.push("/");
                    });
            }
        }
    };
</script>