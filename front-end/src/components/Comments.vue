<template>
  <!-- Div para envolver todo o conteúdo dos comentários -->
  <div class="comments max-w-md mx-auto" >
    <!-- Título dos comentários -->
    <h3 class="text-lg font-semibold mb-4">Comments</h3>

    <!-- Renderização dos comentários existentes com altura limitada e rolagem, e margem inferior adicionada -->
    <div v-if="existingComments && existingComments.length > 0" class="max-h-64 overflow-y-auto mb-6 border rounded-lg p-2 border-gray-300 ">
      <ul>
        <!-- Laço para cada comentário existente -->
        <li v-for="comment in existingComments" :key="comment.id" class="mb-4">
          <!-- Conteúdo do comentário -->
          <div>{{ comment.content }}</div>
          <!-- Informações do usuário do comentário, se disponível -->
          <div v-if="comment.user" class="text-sm text-gray-500">{{ comment.user.name }} - {{ formatDateTime(comment.created_at) }}</div>
        </li>
      </ul>
    </div>

    <!-- Permitir que usuários autenticados adicionem um novo comentário -->
    <div v-if="isLoggedIn">
      <!-- Área de texto para adicionar um novo comentário -->
      <textarea v-model="newComment" class="w-full h-20 p-2 border-2 border-gray-300 rounded-lg mb-4"></textarea>
      <!-- Botão para adicionar um comentário -->
      <button @click="addComment()" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Add Comment</button>
    </div>
    <!-- Caso contrário, mostrar um botão para login -->
    <div v-else>
      <button @click="openLoginModal" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Login to add a comment</button>
    </div>
    <!-- Componente de modal de login -->
    <LoginModal v-if="showLoginModal" @close="showLoginModal = false" @logged="isLoggedIn = checkAuthentication()"/>
  </div>
</template>

<script setup>
import { ref, onBeforeMount } from 'vue';
import axios from 'axios';
import { checkAuthentication } from '../utils/auth.js';
import eventBus from '../utils/EventBus.js';
import { formatDateTime } from '../utils/DateTimeFormatter.js'; 
import LoginModal from './modals/LoginModal.vue'

// Define props para receber a lista de comentários e o status de autenticação
const props = defineProps({
  postId: {
    type: Number
  }
});

// Define variáveis reativas para a entrada de novo comentário e comentários existentes
const newComment = ref('');
const existingComments = ref(null);
const isLoggedIn = ref(checkAuthentication());
const showLoginModal = ref(false);

// Função para buscar os comentários existentes
const fetchComments = async (postId) => {
  try {
    const response = await axios.get(`http://127.0.0.1:8000/api/posts/${postId}/comments`);
    existingComments.value = response.data;

    // Buscar dados do usuário para cada comentário
    await Promise.all(existingComments.value.map(async (comment) => {
      try {
        const userResponse = await axios.get(`http://127.0.0.1:8000/api/user/${comment.user_id}`);
        comment.user = userResponse.data;
      } catch (error) {
        console.error(`Error fetching user for comment with ID ${comment.id}:`, error);
        // Lidar com erro se necessário
      }
    }));

    console.log(existingComments);
  } catch (error) {
    console.error('Error fetching comments:', error);
    // Lidar com erro
  }
};

// Função para adicionar um novo comentário
async function addComment() {
  // Verificar se o usuário está autenticado
  if (!checkAuthentication()) {
    console.error('User is not authenticated. Please log in to add a comment.');
    // Opcionalmente, redirecionar o usuário para a página de login ou exibir uma mensagem de erro
    return;
  }

  try {
    // Obter o token de autenticação do armazenamento local
    const accessToken = localStorage.getItem('accessToken');

    // Definir o cabeçalho de autenticação bearer
    const config = {
      headers: {
        Authorization: `Bearer ${accessToken}`
      }
    };

    // Enviar a solicitação POST com o cabeçalho de autenticação
    const response = await axios.post(
      `http://127.0.0.1:8000/api/posts/${props.postId}/comments`,
      {
        content: newComment.value
      },
      config // Passar o objeto de configuração contendo o cabeçalho de autenticação
    );

    console.log('Comment added successfully:', response.data);

    // Buscar comentários atualizados após adicionar um novo comentário
    fetchComments(props.postId);

    // Limpar o campo de entrada de novo comentário
    newComment.value = '';
  } catch (error) {
    console.error('Error adding comment:', error);
    
  }
}

// Função para abrir o modal de login
const openLoginModal = () => {
  // Adicionar seu código para abrir o modal de login aqui
  showLoginModal.value = true;
};
  
// Buscar os comentários existentes quando o componente é montado
onBeforeMount(() => {
  fetchComments(props.postId);
});

// Realizar autenticação quando o evento 'login' é emitido
eventBus.on('login', () => {
  // Atualizar a variável isLoggedIn para true
  isLoggedIn.value = checkAuthentication();
});

// Realizar autenticação quando o evento 'logout' é emitido
eventBus.on('logout', () => {
  // Atualizar a variável isLoggedIn para false
  isLoggedIn.value = checkAuthentication();
});

// Realizar autenticação quando o evento 'registered' é emitido
eventBus.on('registered', () => {
  // Atualizar a variável isLoggedIn para false
  isLoggedIn.value = checkAuthentication();
});

</script>
