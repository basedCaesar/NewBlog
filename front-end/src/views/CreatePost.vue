<template>
  <!-- Container principal -->
  <div class="container mx-auto mt-8 flex justify-center">
    <!-- Formulário para criar um novo post -->
    <div class="w-full max-w-md border rounded-lg p-8">
      <!-- Título do formulário -->
      <h1 class="text-3xl font-semibold mb-4 text-center">Criar Nova Publicação</h1>
      <!-- Formulário -->
      <form @submit.prevent="createPost">
        <!-- Campo para o título do post -->
        <div class="mb-4">
          <label for="postTitle" class="block text-sm font-medium text-gray-700">Título:</label>
          <input type="text" id="postTitle" v-model="postTitle" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
        </div>
        <!-- Campo para o conteúdo do post -->
        <div class="mb-4">
          <label for="postContent" class="block text-sm font-medium text-gray-700">Conteúdo:</label>
          <textarea id="postContent" v-model="postContent" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 h-32 resize-none" required></textarea>
        </div>
        <!-- Botão para criar o post -->
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded w-full">Criar Postagem</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

// Variáveis reativas para armazenar os dados do post
const postTitle = ref('');
const postContent = ref('');

// Obter instância do router
const router = useRouter();

// Método para criar uma nova postagem no blog
const createPost = async () => {
  try {
    // Obter o token do armazenamento local
    const token = localStorage.getItem('accessToken');

    // Fazer uma requisição para criar o post com cabeçalho de autorização
    const response = await axios.post('http://127.0.0.1:8000/api/posts', {
      title: postTitle.value,
      content: postContent.value
    }, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    });

    // Redirecionar para o post recém-criado
    router.push(`/posts/${response.data.id}`);
  } catch (error) {
    console.error('Erro ao criar postagem:', error);
    // Lidar com o erro
  }
};

</script>
