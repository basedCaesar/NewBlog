<template>
  <!-- Container para exibição do post -->
  <div class="max-w-[800px] mx-auto px-4 py-5 sm:px-6 lg:px-8">
    <!-- Renderizar o router-link apenas quando os dados do usuário estiverem disponíveis -->
    <router-link v-if="user" :to="{ name: 'UserProfile', params: { userId: user.id } }" class="flex items-center space-x-2 mb-4 justify-center">
      <!-- Ícone do perfil do usuário -->
      <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A12.013 12.013 0 0112 15a12.013 12.013 0 016.879 2.804M12 12a3 3 0 100-6 3 3 0 000 6zm0 9a9 9 0 100-18 9 9 0 000 18z"></path>
      </svg>
      <!-- Nome do usuário -->
      <span>{{ user.name }}</span>
    </router-link>

    <!-- Container do card -->
    <div class="card bg-white shadow-lg rounded-lg overflow-hidden">
      <!-- Cabeçalho do card -->
      <div class="card-header p-4 bg-gray-800 text-white text-center">
        <h3 class="text-lg font-semibold">{{ post.title }}</h3> <!-- Exibir título do post -->
      </div>
      
      <!-- Conteúdo do card -->
      <div class="card-content p-4 border-t-0 border-l border-r border-b border-black rounded-b-lg break-all">
        <p class="text-gray-600" style="line-height: 1.6rem;">{{ post.content }}</p> <!-- Exibir conteúdo do post -->
      </div>
    </div>
  </div>
</template>

<script setup>

// Definir as props recebidas pelo componente
const props = defineProps({
  post: Object, // Prop para receber os dados do post
  user: Object, // Prop para receber os dados do usuário
});
</script>



