<template>
  <div id="app" class="flex flex-col min-h-screen">
    <Header />
    <router-view class="flex-grow" :key="$route.fullPath"></router-view>
    <Footer />
  </div>
</template>

<script setup>
import Header from './components/Header.vue'
import Footer from './components/Footer.vue'
</script>

<style>
html, body {
  height: 100%;
  width: 100%;
  margin: 0;
}

#app {
  display: flex;
  flex-direction: column;
  min-height: 100vh; /* Use 100vh for full viewport height */
}
</style>
