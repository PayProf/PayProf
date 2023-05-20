<template>
    <div>
      <canvas id="myChart"></canvas>
    </div>
  </template>
  
  <script setup lang="ts">
  import Chart from 'chart.js/auto';
  import { onMounted } from 'vue';
  import axios from 'axios';
  
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
      const response = await axios.get('http://localhost:5000/Interventions'); // Replace 'your-api-endpoint' with the actual API URL
  
      const data = response.data.map(item => ({
        nombre_heures: item.Nombre_heures,
        date_debut: item.Date_Debut
      }));
  
      config.data.labels = data.map(item => item.date_debut);
      config.data.datasets[0].data = data.map(item => item.nombre_heures);
  
      const myChart = new Chart(document.getElementById('myChart'), config);
    } catch (error) {
      console.error('Error fetching data:', error);
    }
  });
  </script>
  