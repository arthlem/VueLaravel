<template>
    <v-container>
        <h1>Add Project</h1>
    
        <v-form>
            <v-text-field label="Nom" v-model="name" :rules="nameRules" :counter="50" required></v-text-field>
            <v-text-field label="Lien de l'image" v-model="image_link" required></v-text-field>
        </v-form>
        <v-btn color="info" @click="addProject">Add Project</v-btn>
    </v-container>
</template>

<script>
    export default {
        data() {
            return {
                name: "",
                nameRules: [
                    v => !!v || "Le nom est requis",
                    v => v.length <= 50 || "Le nom doit faire moins 50 de caractères"
                ],
                image_link: ""
            };
        },
        methods: {
            addProject() {
                let uri = "http://localhost:8000/api/projects";
                this.axios
                    .post(uri, {
                        name: this.name,
                        image_link: this.image_link,
                        id_creator: 1
                    })
                    .then(response => {
                        this.$router.push("/");
                    });
            }
        }
    };
</script>