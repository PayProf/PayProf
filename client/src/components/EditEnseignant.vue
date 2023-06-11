<template>
    <div class="popup">
        <div class="card flex-shrink-0 w-full max-w-sm shadow-2xl bg-base-100">
            <div class="card-body">
                <form>
                    <!-- Form fields for adding an enseignant -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">PPR</span>
                        </label>
                        <input type="text" v-model="model.Enseignants.PPR" placeholder="PPR" class="input input-bordered" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Nom</span>
                        </label>
                        <input type="text" v-model="model.Enseignants.nom" placeholder="Nom" class="input input-bordered" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Prénom</span>
                        </label>
                        <input type="text" v-model="model.Enseignants.prenom" placeholder="Prénom"
                            class="input input-bordered" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Email</span>
                        </label>
                        <input type="email" v-model="model.Enseignants.email_perso" placeholder="Email"
                            class="input input-bordered" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Etablissement</span>
                        </label>
                        <input type="number" v-model="model.Enseignants.etablissement_id" placeholder="Email"
                            class="input input-bordered" />
                    </div>
                    <div class="form-control mt-6">
                        <button type="submit" class="btn btn-primary" style="border-radius: 10px;"
                            @click="updateEnseignant()">Save</button>
                        <button class="btn btn-primary" style="border-radius: 10px;">Cancel</button>

                    </div>
                </form>
            </div>
        </div>

    </div>
</template>
  
<script>
import axios from 'axios';
export default {
    name: 'EditEnseignant',
    data() {
        return {
            EnseignantId: "",
            model: {
                Enseignants: {
                    PPR: "",
                    nom: "",
                    prenom: "",
                    Email: "",
                    Grade: "", //i still need to a drop down to check if its PA, PR, PH
                    DateNaissance: ""
                }
            }
        }
    },
    mounted() {
        this.EnseignantId = this.$route.params.id;
        this.getEnseignantData(this.$route.params.id);
    },

    methods: {
        getEnseignantData(EnseignantId) {
            axios.get(`http://localhost:8000/api/Enseignant/${EnseignantId}`).then(result => {
                this.model.Enseignants = result.data.Enseignants
            })

        },
        async updateEnseignant() {
            var myThis = this;
            await axios.put(`http://localhost:8000/api/Enseignant/${this.EnseignantId}`, this.model.Enseignants) // this.model... is to show the credentials on the input form before the the insert
                .then(result => {
                    console.log(result.data);
                })
        }
    }

};
</script>
  
<style>
.popup {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

.popup-content {
    background-color: #fff;
    padding: 20px;
}
</style>