<template>
  <!-- Definição da transição para o modal -->
  <transition name="modal">
    <div class="fixed inset-0 overflow-y-auto flex items-center justify-center z-50">
      <!-- Overlay escuro de fundo -->
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

      <!-- Conteúdo do modal -->
      <div class="relative bg-white rounded-lg p-8 max-w-md w-full">
        <!-- Botão para fechar o modal -->
        <button class="absolute top-0 right-0 m-4 text-gray-500 hover:text-gray-700" @click="close">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>

        <!-- Título do modal -->
        <h2 class="text-2xl font-semibold mb-4">Alter User Info:</h2>

        <!-- Formulário para alterar informações do usuário -->
        <form @submit.prevent="submitForm">
          <!-- Campo para o nome -->
          <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
            <input type="text" id="name" v-model="name" required class="mt-1 p-2 block w-full border-black rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
          </div>

          <!-- Campo para o email -->
          <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
            <input type="email" id="email" v-model="email" autocomplete="email" required class="mt-1 p-2 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
          </div>

          <!-- Botão para submeter o formulário -->
          <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">Alterar</button>
        </form>
      </div>
    </div>
  </transition>
</template>

<script setup>
import { defineProps, ref } from 'vue';
import axios from 'axios';

// Definindo os eventos emitidos pelo modal
const emit = defineEmits(['close', 'altered']);

// Definindo as propriedades do componente
const props = defineProps({
  initialName: String,
  initialEmail: String
});

// Referências reativas para o nome e email
const name = ref(props.initialName);
const email = ref(props.initialEmail);

// Função para fechar o modal
const close = () => {
  emit('close'); // Emitindo o evento 'close'
};

// Função para emitir evento 'altered' após a alteração das informações do usuário
const altered = () => {
  emit('altered'); // Emitindo o evento 'altered'
};

// Função para submeter o formulário de alteração das informações do usuário
const submitForm = async () => {
  try {
    // Verificando se o nome e o email não são nulos e foram alterados
    if ((!name.value || !email.value) || (name.value === props.initialName && email.value === props.initialEmail)) {
      // Se não foram alterados ou são nulos, não enviar a requisição
      return;
    }

    // Verificando se o email está em um formato válido usando uma expressão regular
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email.value)) {
      // Se o email não for válido, exibir uma mensagem de erro ou lidar com ele conforme necessário
      console.error('Invalid email format');
      return;
    }

    // Obtendo o ID do usuário do armazenamento local
    const userId = localStorage.getItem('userId');
    // Enviando requisição PUT para atualizar as informações do usuário
    await axios.put(`http://127.0.0.1:8000/api/user/profile/${userId}`, {
      name: name.value,
      email: email.value
    }, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('accessToken')}`,
      },
    });

    altered(); // Emitindo evento 'altered'
    close(); // Fechando o modal após a alteração

    
  } catch (error) {
    console.error('Error updating user profile:', error);
    
  }
};
</script>

<style scoped>
/* Definindo a transição para o modal */
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.5s;
}
.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}
</style>
