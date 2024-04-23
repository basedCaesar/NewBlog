<template>
  <!-- Container principal -->
  <div class="max-w-[800px] mx-auto px-4 py-5 sm:px-6 lg:px-8">
    <!-- Exibir mensagem de carregamento enquanto os posts estão sendo carregados -->
    <div v-if="isLoading">
      <p>Carregando...</p>
    </div>
    <!-- Exibir lista de posts quando os posts estiverem disponíveis -->
    <div v-else-if="posts">
      <!-- Componente para exibir a lista de posts do usuário -->
      <UserPostList :posts="posts" />
    </div>
    <!-- Exibir mensagem quando não houver posts disponíveis -->
    <div v-else>
      <p>Nenhuma postagem disponível.</p>
    </div>
  </div>
</template>

<script setup>
import { ref, watchEffect } from 'vue';
import axios from 'axios';
import UserPostList from '../components/UserPostList.vue';

// Define dados reativos
const posts = ref([]); // Array para armazenar os posts
const isLoading = ref(true); // Variável para indicar se os posts estão sendo carregados

// Função para buscar os posts
const fetchPosts = async () => {
try {
  const response = await axios.get('http://127.0.0.1:8000/api/posts');
  posts.value = response.data; // Atualiza a lista de posts com os dados obtidos da API
} catch (error) {
  console.error('Erro ao buscar as postagens:', error);
} finally {
  isLoading.value = false; // Define isLoading como false quando a busca estiver concluída
}
};

// Buscar os posts quando o componente for montado
watchEffect(() => {
fetchPosts();
});
</script>
