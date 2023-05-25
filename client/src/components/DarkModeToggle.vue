<!-- DarkModeToggle.vue -->

<template>
    <button @click="toggleDarkMode" class="btn" :class="{'dark': darkMode}">
      <i class="text-xl" :class="{'far fa-sun': !darkMode, 'far fa-moon': darkMode}"></i>
    </button>
  </template>
  
  <script>
  export default {
    name:'DarkModeToggle',
    data() {
      return {
        darkMode: false,
      };
    },
    methods: {
      toggleDarkMode() {
        this.darkMode = !this.darkMode;
        document.body.classList.toggle('dark', this.darkMode);
      },
    },
  };
  </script>
  