<template>
  <div class="post-detail">
    <!-- Exibir indicador de carregamento enquanto os dados do post estão sendo carregados -->
    <div v-if="!post">
      Carregando postagem...
    </div>

    <!-- Exibir detalhes da postagem quando os dados do post estiverem disponíveis -->
    <div v-else>
      <!-- Incluir componente PostContent e passar post e user como props -->
      <PostContent :post="post" :user="user" />

      <!-- Exibir componente de comentários quando os dados do post estiverem disponíveis -->
      <Comments v-if="post" :postId="post.id" />
    </div>
  </div>
</template>

<script setup>
import { ref, onBeforeMount } from 'vue';
import axios from 'axios';
import { useRoute } from 'vue-router';
import Comments from '@/components/Comments.vue';
import PostContent from '@/components/PostContent.vue';

// Variáveis reativas para armazenar os dados do post e do usuário
const post = ref(null);
const user = ref(null);
const route = useRoute();

// Hook onBeforeMount para buscar os dados do post antes do componente ser montado
onBeforeMount(async () => {
  try {
    const postId = route.params.postId; // Obtém o ID do post da rota
    const response = await axios.get(`http://127.0.0.1:8000/api/posts/${postId}`); // Busca os dados do post na API
    post.value = response.data; // Atualiza os dados do post
    // Busca os dados do usuário com base no ID do usuário associado ao post
    const userId = post.value.user_id; // Obtém o ID do usuário associado ao post
    const userResponse = await axios.get(`http://127.0.0.1:8000/api/user/${userId}`); // Busca os dados do usuário na API
    user.value = userResponse.data; // Atualiza os dados do usuário
  } catch (error) {
    console.error('Erro ao buscar os dados da postagem:', error);
  }
});
</script>
