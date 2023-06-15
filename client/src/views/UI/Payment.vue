<template>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

    <div class="col-md-12 mx-20 mt-24">
        <div class="row">

            <div class="receipt-main col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
                <div class="row flex-row ">
                    <div class="receipt-header">
                        <div class="col-xs-8 col-sm-8 col-md-8 text-left">
                            <div class="receipt-left">
                                <b>
                                    <h5>{{ this.Profile.nom }} {{ this.Profile.prenom }}  </h5>
                                </b>
                                <p><b>PPR :</b>{{ this.Profile.PPR }} </p>
                                <p><b>Email :</b> {{ this.Profile.Email }} </p>
                            </div>
                        </div>

                    </div>
                </div>

                <div>
                    <table class="table table-bordered w-full mt-0">
                        <thead class=" bg-slate-500">
                            <tr>
                                <th>Intitule</th>
                                <th>Nombre d'heure</th>
                                <th>Semestre</th>
                                <th>Paiement</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(Intervention,id)  in this.Interventions "  :key="id">
                                <td class="col-md-9">{{Intervention.intitule_intervention}}</td>
                                <td class="col-md-9">{{Intervention.Nbr_heures}}</td>
                                <td class="col-md-9">{{Intervention.semestre}}</td>
                                <td class="col-md-3">{{Paiements[id].Net }}</td> 
                            </tr>
                            <tr>
                                <td class="col-md-9"></td>
                                <td class="col-md-9"><h3>{{ this.Hours }}</h3></td>
                                <td></td>
                                <td class="text-center text-danger "> <h2><strong>Total: {{ this.tot }}</strong></h2> </td>
                                
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="receipt-header receipt-header-mid receipt-footer">
                        <div class="col-xs-8 col-sm-8 col-md-8 text-left">
                            <div class="receipt-right">
                                <h5 style="color: rgb(92, 90, 90);">PayProf</h5>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="flex justify-center mb-24" v-if="UserRole == 0">
        <button class="btn btn-neutral" @click="downloadPDF()" id="btn">Telecharger payement</button>
    </div>
    
</template>

<script>
import store from '../../store.js'
import axios from 'axios'
import {useToast} from "vue-toastification";
export default {
    name: 'Payment',
    data() {
        return {
            isVisible: false,
            Interventions:[],
            Profile:[],
            Paiements:[],
            Hours:"",
            UserRole: store.state.user.role,
          tot:""
        }
    },
    methods: {
        showReceipt() {
            this.isVisible = !this.isVisible
        },
        downloadPDF() {
            document.getElementById("header").style.display = 'none'
            document.getElementById("footer").style.display = 'none'
            document.getElementById("btn").style.display = 'none'
            window.print()
        },
        async getPayment() {
            try {
                const token = store.state.user.token;
                const config = {
                    headers: { Authorization: `Bearer ${token}` }
                };
                const response = await axios.get('http://127.0.0.1:8000/api/Enseignant/ens/MyPayments', config);
                this.Paiements = response.data.ens
              this.tot = response.data.sum
              console.log(response.data.sum)
                
            }
            catch (error) {
                console.log(error)
              const toast = useToast();
              toast.error('Pas de Paiements',{
                timeout:3000,
              });
            }
        },
        async getHours(){
            try {
                const token = store.state.user.token;
                const config = {
                    headers: { Authorization: `Bearer ${token}` }
                };
                const response = await axios.get('http://127.0.0.1:8000/api/Enseignant/ens/MyHours', config);
                console.log(response)
                this.Hours = response.data.hours;
            }
            catch (error) {
                console.log(error)
            }
        },
        async getProfile(){
            try {
                const token = store.state.user.token;
                const config = {
                 headers: { Authorization: `Bearer ${token}` }
                };

                const res= await axios.get('http://127.0.0.1:8000/api/Enseignant/ens/ShowMyProfil',config)
                console.log(res)
                this.Profile=res.data.data;
            }
            catch (error) {
                console.log(error)
            }
            },
            async getInterventions(){
            try {
                const token = store.state.user.token;
                const config = {
                 headers: { Authorization: `Bearer ${token}` }
                };

                const res= await axios.get('http://127.0.0.1:8000/api/Enseignant/ens/MyIntervention',config)
                console.log(res)
                this.Interventions=res.data.data;
            }
            catch (error) {
                console.log(error)
            }
            }


    },
    async mounted(){
        await this.getPayment();
        await this.getHours();
        await this.getProfile();
        await this.getInterventions();

    }

}
</script>

<style>
body {
    background: #eee;
    margin-top: 20px;
}

.receipt-main {
    background: #ffffff none repeat scroll 0 0;
    border-bottom: 12px solid #333333;
    border-top: 12px solid #333333;
    margin-top: 50px;
    margin-bottom: 50px;
    padding: 40px 30px !important;
    position: relative;
    box-shadow: 0 1px 21px #acacac;
    color: #333333;
    font-family: open sans;
}

.receipt-main p {
    color: #333333;

    line-height: 1.42857;
}

.receipt-footer h1 {
    font-size: 15px;
    font-weight: 400 !important;
    margin: 0 !important;
}

.receipt-main::after {
    background: #414143 none repeat scroll 0 0;
    content: "";
    height: 5px;
    left: 0;
    position: absolute;
    right: 0;
    top: -13px;
}

.receipt-main thead {
    background: #414143 none repeat scroll 0 0;
}

.receipt-main thead th {
    color: rgb(11, 11, 11);
}

.receipt-right h5 {
    font-size: 16px;
    font-weight: bold;
    margin: 0 0 7px 0;
}





.receipt-main td {
    padding: 9px 20px !important;
}

.receipt-main th {
    padding: 13px 20px !important;
}

.receipt-main td {
    font-size: 13px;
    font-weight: initial !important;
}

.receipt-main td p:last-child {
    margin: 0;
    padding: 0;
}

.receipt-main td h2 {
    font-size: 20px;
    font-weight: 900;
    margin: 0;
    text-transform: uppercase;
}



.receipt-header-mid {
    margin: 24px 0;
    overflow: hidden;
}

#container {
    background-color: #dcdcdc;
}
</style>