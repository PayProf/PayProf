<template>
  <!-- Profile -->
  <div class="hero min-h-screen bg-base-200" v-show="showProfile">
    <img src="/images/stock/photo-1635805737707-575885ab0820.jpg" class="max-w-sm rounded-lg shadow-2xl" />
    <div class="hero-content flex-col lg:flex-row ">
      <div>
        <h1 class="text-5xl font-bold">Nom Prénom</h1>
        <p class="py-2">Email</p>
        <p class="py-2">Grade</p>
        <p class="py-2">PPR: #</p>
        <p class="py-2">Etablissement</p>
      </div>
    </div>
  </div>
  <!-- TABLE ETABLISSEMENT -->
  <div class="relative overflow-x-auto shadow-md sm:rounded-lg" v-show="showTableEtab">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">

      <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th scope="col" class="px-6 py-3">
            Code
          </th>
          <th scope="col" class="px-6 py-3">
            Nom
          </th>
          <th scope="col" class="px-6 py-3">
            Telephone
          </th>
          <th scope="col" class="px-6 py-3">
            Fax
          </th>
          <th scope="col" class="px-6 py-3">
            Nombre enseignants
          </th>
          <th scope="col" class="px-6 py-3">
            Ville
          </th>
          <th scope="col" class="px-6 py-3">
            Action
          </th>
          <th scope="col" class="px-6 py-3">
            <span class="sr-only">Edit</span>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
          <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            Apple MacBook Pro 17"
          </th>
          <td class="px-6 py-4">
            Silver
          </td>
          <td class="px-6 py-4">
            Laptop
          </td>
          <td class="px-6 py-4">
            $2999
          </td>
          <td class="px-6 py-4">
            Silver
          </td>
          <td class="px-6 py-4">
            Laptop
          </td>
          <td class="px-6 py-4 text-right">
            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
          </td>
        </tr>
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
          <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            Microsoft Surface Pro
          </th>
          <td class="px-6 py-4">
            White
          </td>
          <td class="px-6 py-4">
            Laptop PC
          </td>
          <td class="px-6 py-4">
            $1999
          </td>
          <td class="px-6 py-4 text-right">
            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
          </td>
        </tr>
        <tr class="bg-white dark:bg-gray-800">
          <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            Magic Mouse 2
          </th>
          <td class="px-6 py-4">
            Black
          </td>
          <td class="px-6 py-4">
            Accessories
          </td>
          <td class="px-6 py-4">
            $99
          </td>
          <td class="px-6 py-4 text-right">
            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <!-- TABLE ADMINS -->
  <div class="relative overflow-x-auto shadow-md sm:rounded-lg" v-show="showTableAdm">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">

      <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th scope="col" class="px-6 py-3">
            Code
          </th>
          <th scope="col" class="px-6 py-3">
            Nom
          </th>
          <th scope="col" class="px-6 py-3">
            Telephone
          </th>
          <th scope="col" class="px-6 py-3">
            Fax
          </th>
          <th scope="col" class="px-6 py-3">
            Nombre enseignants
          </th>
          <th scope="col" class="px-6 py-3">
            Ville
          </th>
          <th scope="col" class="px-6 py-3">
            Action
          </th>
          <th scope="col" class="px-6 py-3">
            <span class="sr-only">Edit</span>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
          <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            Apple MacBook Pro 17"
          </th>
          <td class="px-6 py-4">
            Silver
          </td>
          <td class="px-6 py-4">
            Laptop
          </td>
          <td class="px-6 py-4">
            $2999
          </td>
          <td class="px-6 py-4">
            Silver
          </td>
          <td class="px-6 py-4">
            Laptop
          </td>
          <td class="px-6 py-4 text-right">
            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
          </td>
        </tr>
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
          <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            Microsoft Surface Pro
          </th>
          <td class="px-6 py-4">
            White
          </td>
          <td class="px-6 py-4">
            Laptop PC
          </td>
          <td class="px-6 py-4">
            $1999
          </td>
          <td class="px-6 py-4 text-right">
            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
          </td>
        </tr>
        <tr class="bg-white dark:bg-gray-800">
          <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            Magic Mouse 2
          </th>
          <td class="px-6 py-4">
            Black
          </td>
          <td class="px-6 py-4">
            Accessories
          </td>
          <td class="px-6 py-4">
            $99
          </td>
          <td class="px-6 py-4 text-right">
            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <!-- TABLE DIRECTEURS -->
  <div class="relative overflow-x-auto shadow-md sm:rounded-lg" v-show="showTableDir">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">

      <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th scope="col" class="px-6 py-3">
            Code
          </th>
          <th scope="col" class="px-6 py-3">
            Nom
          </th>
          <th scope="col" class="px-6 py-3">
            Telephone
          </th>
          <th scope="col" class="px-6 py-3">
            Fax
          </th>
          <th scope="col" class="px-6 py-3">
            Nombre enseignants
          </th>
          <th scope="col" class="px-6 py-3">
            Ville
          </th>
          <th scope="col" class="px-6 py-3">
            Action
          </th>
          <th scope="col" class="px-6 py-3">
            <span class="sr-only">Edit</span>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
          <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            Apple MacBook Pro 17"
          </th>
          <td class="px-6 py-4">
            Silver
          </td>
          <td class="px-6 py-4">
            Laptop
          </td>
          <td class="px-6 py-4">
            $2999
          </td>
          <td class="px-6 py-4">
            Silver
          </td>
          <td class="px-6 py-4">
            Laptop
          </td>
          <td class="px-6 py-4 text-right">
            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
          </td>
        </tr>
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
          <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            Microsoft Surface Pro
          </th>
          <td class="px-6 py-4">
            White
          </td>
          <td class="px-6 py-4">
            Laptop PC
          </td>
          <td class="px-6 py-4">
            $1999
          </td>
          <td class="px-6 py-4 text-right">
            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
          </td>
        </tr>
        <tr class="bg-white dark:bg-gray-800">
          <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            Magic Mouse 2
          </th>
          <td class="px-6 py-4">
            Black
          </td>
          <td class="px-6 py-4">
            Accessories
          </td>
          <td class="px-6 py-4">
            $99
          </td>
          <td class="px-6 py-4 text-right">
            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { mapState } from 'vuex'

export default {

  name: 'Etabs',
  components: {

  },

  data() {
    return {
      showProfile: true,
      showTableEtab: false,
      showTableAdm: false,
      showTableDir: false

    }
  },
  methods: {

    ToggleProfile() {
      this.showProfile = !this.showProfile,
        this.showTableEtab = false,
        this.showTableAdm = false,
        this.showTableDir = false
    },
    ToggleEtab() {
      this.showTableEtab = !this.showTableEtab,
        this.showTableProfile = false,
        this.showTableAdm = false,
        this.showProfile = false
    },
    ToggleAdm() {
      this.showTableAdm = !this.showTableAdm
      this.showTableEtab = false,
        this.showTableDir = false,
        this.showProfile = false
    },
    ToggleDir() {
      this.showTableDir = !this.showTableDir,
        this.showTableEtab = false,
        this.showTableAdm = false,
        this.showProfile = false
    }
  },
  computed: {
    ...mapState([
      'user',

    ])
  }

}
</script>

<style></style>