<template>
  <div class="max-w-[800px] mx-auto px-4 py-5 sm:px-6 lg:px-8">
    <!-- Exibir indicador de carregamento enquanto os dados do usuário estão sendo carregados -->
    <div v-if="!user">
      Carregando perfil do usuário...
    </div>

    <!-- Exibir informações do perfil do usuário assim que os dados do usuário forem carregados -->
    <div v-else class="min-w-[600px]">
      <UserInfo :user="user" />
      <UserPostList :posts="user.posts" />
    </div>
  </div>
</template>

<script setup>
import { ref, watchEffect } from 'vue';
import axios from 'axios';
import { useRoute } from 'vue-router';
import UserPostList from '../components/UserPostList.vue';
import UserInfo from '../components/UserInfo.vue';

// Variável reativa para armazenar os dados do usuário
const user = ref(null);
const route = useRoute();

// Função para buscar o perfil do usuário
const fetchUserProfile = async (userId) => {
  try {
    const response = await axios.get(`http://127.0.0.1:8000/api/user/${userId}`);
    user.value = response.data;
  } catch (error) {
    console.error('Erro ao buscar os dados do usuário:', error);
    
  }
};

// Observador de efeito para buscar os dados do usuário quando o ID do usuário mudar
watchEffect(async () => {
  // Verifica se userId é um valor válido antes de buscar os dados do usuário
  if (route.params.userId) {
    await fetchUserProfile(route.params.userId);
  }
});
</script>

<style scoped>
.profile-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}
</style>
