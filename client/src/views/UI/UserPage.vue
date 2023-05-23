<template>
  <div class="relative flex min-h-screen ">
    <!-- Sidebar -->
    <div
      class="bg-gray-700 text-gray-400 w-64 space-y-6 px-2 py-4 absolute inset-y-0 left-0 md:relative md:-translate-x-0 transform -translate-x-full transition duration-200 ease-in-out "
      :class="{ 'relative -translate-x-0': showSidebar }">
      <a href="" class="flex items-center space-x-2 px-4">
        <span class="text-2xl font-semibold">ProfPay</span>

      </a>
      <nav>
        <a href=""
          class="group flex items-center py-3 space-x-4 px-4 group hover:bg-gray-800 rounded transition duration-200">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
          </svg>
          <span class="text-gray-400 group-hover:text-gray-200"> Profile </span>
        </a>

        <a href=""
          class=" group flex items-center py-3 space-x-4 px-4  hover:bg-gray-800 rounded transition duration-200">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0112 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" />
          </svg>

          <span class="text-gray-400 group-hover:text-gray-200" @click="showProfile = !showProfile "> Interventions </span>

        </a>

        <a href="" class="group flex items-center py-3 space-x-4 px-4 hover:bg-gray-800 rounded transition duration-200">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
          </svg>
          <span class="text-gray-400 group-hover:text-gray-200">Paiements</span>

        </a>
      </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1">
      <!-- header -->
      <div class="bg-white shadow px-2 py-4  flex-row ">
        <button @click="showSidebar = !showSidebar" class="text-gray-400">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-8 h-8">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" />
          </svg>

        </button>
        <h1 class="text-gray-800 text-xl font-bold ml-2  text-center">PayProf</h1>
      </div>
      <!-- body -->
      <div class="hero min-h-screen bg-base-200" v-show="showProfile">
        <div class="hero-content flex-col lg:flex-row ">
          <div>
            <h1 class="text-5xl font-bold">Nom Prénom</h1>
            <p class="py-2">Email</p>
            <p class="py-2">Grade</p>
            <p class="py-2">PPR: #</p>
            <p class="py-2">Etablissement</p>
            <button class="btn btn-primary" @click="showProfile = !showProfile ; showTable= !showTable">Voir intérvention</button>
          </div>
        </div>
      </div>
      <!------------------------------------------------------------------ TABLE INTERVENTIONS ------------------------------------------------------->
      <div v-show="showTable">
        <h1 class="text-5xl font-bold ">Table d'intérvention</h1>
        <div class="overflow-x-auto ml-20 ">
          <table class="table table-zebra w-80 border border-slate-500 ">
            <!-- head -->
            <thead>
              <tr>
                <th></th>
                <th>Nom</th>
                <th>Etablissement</th>
                <th>Intetule Intervention</th>
                <th>Année universitaire</th>
                <th>Semestre</th>
                <th>Date début</th>
                <th>Date fin</th>
                <th>Nombre d'heure</th>

              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>
        </div>
        <div class="btn-group">
          <button class="btn">1</button>
          <button class="btn btn-active">2</button>
          <button class="btn">3</button>
          <button class="btn">4</button>
        </div>

      </div>
    </div>
    <!--  -->

  </div>
</template>

<script>
import { ref } from "vue"
export default {
  setup() {
    const showSidebar = ref(false);
    const showProfile = ref(true);
    const showTable = ref(false)

    return {
      showSidebar,
      showProfile,
      showTable
    }
  }




}
</script>

<style>
.text-5xl{
  margin-top: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.table{
  margin-top: 3%;
  margin-left: 5%;
 
}

.btn-group{
  margin-top: 3%;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>