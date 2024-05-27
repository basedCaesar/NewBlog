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
        <h2 class="text-2xl font-semibold mb-4">Login</h2>

        <!-- Formulário de login -->
        <form @submit.prevent="submitForm">
          <!-- Campo de email -->
          <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" v-model="email" autocomplete="email" required class="mt-1 p-2 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
          </div>
          <!-- Campo de senha -->
          <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" id="password" v-model="password" autocomplete="current-password" required class="mt-1 p-2 block w-full border-black rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
          </div>
          <!-- Botão de login -->
          <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">Login</button>
        </form>
      </div>
    </div>
  </transition>
</template>

<script setup>
import { ref } from 'vue';
import axiosInstance from '../../utils/axiosInstance';
import eventBus from '../../utils/EventBus';

// Definição das referências reativas para email e senha
const email = ref('');
const password = ref('');

// Definição do evento emitido pelo modal
const emit = defineEmits(['close', 'logged']);

// Função para fechar o modal
const close = () => {
  emit('close'); // Emitindo o evento 'close'
};

// Função para emitir o evento 'logged' após o login do usuário
const logged = () => {
  emit('logged'); // Emitindo o evento 'logged'
};

// Função para submeter o formulário de login
const submitForm = async () => {
  try {
    // Fetch the CSRF cookie
    await axiosInstance.get('/sanctum/csrf-cookie');

    // Realizando a requisição POST para fazer login
    const response = await axiosInstance.post('/auth/login', {
      email: email.value,
      password: password.value
    });

    console.log('User logged:', response.data);

    // Armazenando o token de acesso e o ID do usuário no armazenamento local
    localStorage.setItem('accessToken', response.data.token);
    localStorage.setItem('userId', response.data.user.id);

    logged(); // Emitindo o evento 'logged'
    eventBus.emit('login'); // Emitindo evento 'login' via EventBus
    close(); // Fechando o modal após o login

  } catch (error) {
    console.error('Error logging in user:', error);
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
