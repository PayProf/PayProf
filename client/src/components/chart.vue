<template>
    <div>
      <canvas id="myChart"></canvas>
    </div>
  </template>
  
  <script setup lang="ts">
  import Chart from 'chart.js/auto';
  import { onMounted } from 'vue';
  import axios from 'axios';
  import store from '../store.js';
  
  const config = {
    type: 'line',
    data: {
      labels: [],
      datasets: [{
        label: 'Nombre_heures',
        data: [],
        fill: false,
        borderColor: 'rgb(75, 192, 192)',
      }]
    },
    options: {
      transitions: {
        show: {
          animations: {
            x: { from: 0 },
            y: { from: 0 }
          }
        },
        hide: {
          animations: {
            x: { to: 0 },
            y: { to: 0 }
          }
        }
      }
    }
  };
  
  onMounted(async () => {
    try {
      const response = await axios.get('http://127.0.0.1:8000/api/Enseignant/'+store.state.user.id+'/MyIntervention'); // Replace 'your-api-endpoint' with the actual API URL

      const interventions = response.data.data.interventions;

      const data = interventions.map(item => ({
        NbrHeures: item.NbrHeures,
        DateDebut: item.DateDebut
      }));

      config.data.labels = data.map(item => item.DateDebut);
      config.data.datasets[0].data = data.map(item => item.NbrHeures);
      console.log(config.data.labels)
  
      const myChart = new Chart(document.getElementById('myChart'), config);
    } catch (error) {
      console.error('Error fetching data:', error);
    }
  });
  </script>
  