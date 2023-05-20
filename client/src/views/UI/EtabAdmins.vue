<template>

    <h1 class="text-5xl font-bold mt-24 text-gray-700 ">Table admins</h1>
    <div class="overflow-x-auto border">
  <table class="table w-screen botrder">
    <!-- head -->
    <thead>
      <tr >
        <th></th>
        <th>PPR</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email Personnel</th>
        <th>Prénom</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <!-- row 1 -->
      <tr>
        <th>1</th>
        <td>Cy Ganderton</td>
        <td>Quality Control Specialist</td>
        <td>Blue</td>
      </tr>
      <!-- row 2 -->
      <tr class="hover">
        <th>2</th>
        <td>Hart Hagerty</td>
        <td>Desktop Support Technician</td>
        <td>Purple</td>
      </tr>
      <!-- row 3 -->
      <tr>
        <th>3</th>
        <td>Brice Swyre</td>
        <td>Tax Accountant</td>
        <td>Red</td>
      </tr>
    </tbody>
  </table>
</div>

<button class="btn btn-outline btn-success ">Ajouter un admin</button>
  
  
</template>

<script>
export default {
    name: 'EtabAdmins'
}
</script>

<style>
table{
   margin-top: 10% ;
}
.button{
    margin-top: 10% ;
    padding-right: 5%;
}
</style>