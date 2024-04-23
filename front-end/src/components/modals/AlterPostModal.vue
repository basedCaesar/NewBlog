<template>
  <!-- Definição da estrutura do modal -->
  <transition name="modal">
    <div class="fixed inset-0 overflow-y-auto flex items-center justify-center z-50">
      <!-- Overlay escuro -->
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

      <!-- Conteúdo do modal -->
      <div class="relative bg-white rounded-lg p-8 max-w-md w-full">
        <!-- Botão de fechar o modal -->
        <button class="absolute top-0 right-0 m-4 text-gray-500 hover:text-gray-700" @click="close">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>

        <!-- Título do modal -->
        <h2 class="text-2xl font-semibold mb-4">Alter Post Info:</h2>

        <!-- Formulário de alteração do post -->
        <form @submit.prevent="submitForm">
          <!-- Campo de título -->
          <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Title:</label>
            <input type="text" id="title" v-model="title" required class="mt-1 p-2 block w-full border-black rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
          </div>

          <!-- Campo de conteúdo -->
          <div class="mb-4">
            <label for="content" class="block text-sm font-medium text-gray-700">Content:</label>
            <textarea id="content" v-model="content" required rows="5" class="mt-1 p-2 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
          </div>

          <!-- Botão para submeter o formulário -->
          <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">Alterar</button>
        </form>
      </div>
    </div>
  </transition>
</template>

<script setup>
// Importando funções relevantes
import { defineProps, ref } from 'vue';
import axios from 'axios';

// Definindo os eventos emitidos pelo modal
const emit = defineEmits(['close', 'altered']);

// Definindo as props do componente
const props = defineProps({
  initialTitle: String,
  initialContent: String,
  postId: {
    type: Number,
    required: true
  }
});

// Referências reativas para o postId, título e conteúdo
const postIdFromParent = ref(props.postId);
const title = ref(props.initialTitle);
const content = ref(props.initialContent);

// Função para fechar o modal
const close = () => {
  emit('close'); // Emitindo o evento 'close'
};

// Função para emitir evento 'altered' após a alteração do post
const altered = () => {
  emit('altered'); // Emitindo o evento 'altered'
};

// Função para submeter o formulário de alteração do post
const submitForm = async () => {
  try {
    // Verificando se o título e o conteúdo foram alterados
    if ((!title.value || !content.value) || (title.value === props.initialTitle && content.value === props.initialContent)) {
      return; // Se não foram alterados, não enviar a requisição
    }

    // Enviando requisição PUT para atualizar o post
    await axios.put(`http://127.0.0.1:8000/api/posts/${postIdFromParent.value}`, {
      title: title.value,
      content: content.value
    }, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('accessToken')}`,
      },
    });

    altered(); // Emitindo evento 'altered'
    close(); // Fechando o modal após a alteração

    
  } catch (error) {
    console.error('Error updating post:', error);
    
  }
};
</script>

<style scoped>
/* Estilização da transição do modal */
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.5s;
}
.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}
</style>
