<template>
   <div class="p-4 mt-20 sm:mx-30">
        <div class="p-4 border-2 border-gray-200  rounded-lg ">
            <div class="flex items-center justify-center h-60 mb-6 mt-10 rounded bg-gray-50 ">
                <div class="card card-compact w-full h-full bg-base-100 drop-shadow-md ">
                    <figure><img src=""  /></figure>
                    <div class="card-body">
                        <h2 class="card-title">Table des administrateurs</h2>
                        <p>If a dog chews shoes whose shoes does he choose?</p>
                        <div class="card-actions justify-end">
                            
                            <button class="btn btn-primary" @click="redirectTableAdmin()">Consulter</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-6 mb-4 pt-6">
                <div class="flex items-center justify-center rounded bg-gray-50 h-40 ">
                    <div class="card card-compact w-full h-full bg-base-100 drop-shadow-md ">
                        <figure><img src=""  /></figure>
                        <div class="card-body">
                            <h2 class="card-title">Tables des directeurs</h2>
                            <p>If a dog chews shoes whose shoes does he choose?</p>
                            <div class="card-actions justify-end">
                                <button class="btn btn-primary" @click="redirectTableDirecteur()">Consulter</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-center rounded bg-gray-50 h-40 ">
                    <div class="card card-compact w-full h-full bg-base-100 drop-shadow-md ">
                        <figure><img src=""  /></figure>
                        <div class="card-body">
                            <h2 class="card-title">tables des etablissements</h2>
                            <p>If a dog chews shoes whose shoes does he choose?</p>
                            <div class="card-actions justify-end">
                                <button class="btn btn-primary" @click="redirectTableEtablissement()">Consulter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "AdminUAE",
    methods:{
        redirectTableAdmin(){
            this.$router.push('/TableAdmins')
        },
        redirectTableDirecteur(){
            this.$router.push('/TableDirecteurs')
        },
        redirectTableEtablissement(){
            this.$router.push('/Etablissements')
        }

    }
}
</script>
    
<style>

</style>