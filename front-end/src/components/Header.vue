<template>
  <!-- Cabeçalho da aplicação -->
  <header class="bg-gray-800 py-4">
    <!-- Container para centralizar e alinhar itens do cabeçalho -->
    <div class="container mx-auto flex justify-between items-center">
      <!-- Link do logotipo -->
      <router-link :to="'/'" class="flex-grow justify-center items-center hidden md:flex">
        <!-- Texto do logotipo -->
        <h1 class="text-white text-2xl font-semibold">New<span class="text-blue-500">B</span><span class="text-yellow-500">l</span><span class="text-pink-500">o</span><span class="text-green-500">g</span></h1>
      </router-link>

      <!-- Botões diferentes com base no status de autenticação -->
      <div>
        <!-- Se o usuário estiver autenticado -->
        <div v-if="isLoggedIn">
          <!-- Botão para visualizar o perfil -->
          <router-link :to="`/profile/${userId}`" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded mr-2">Profile</router-link>
          <!-- Botão para fazer logout -->
          <button @click="logout" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded mr-2">Logout</button>
        </div>
        <!-- Se o usuário não estiver autenticado -->
        <div v-else>
          <!-- Botão para fazer login -->
          <button @click="login" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded mr-2">Login</button>
          <!-- Botão para se registrar -->
          <button @click="register" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">Register</button>
        </div>
      </div>
    </div>
   
    <!-- Escutar o evento close emitido pelo LoginModal -->
    <LoginModal v-if="showLoginModal" @close="showLoginModal = false" @logged="handleLoggedIn"/>
    <!-- Escutar o evento close emitido pelo RegistrationModal -->
    <RegistrationModal v-if="showRegistrationModal" @close="showRegistrationModal = false" @registered="handleRegistered"/>
  </header>
</template>

<script setup>
import { ref } from 'vue';
import RegistrationModal from './modals/RegistrationModal.vue';
import LoginModal from './modals/LoginModal.vue';
import axiosInstance from '../utils/axiosInstance';
import { checkAuthentication } from '../utils/auth.js';
import eventBus from '../utils/EventBus.js';

// Criar uma propriedade de dados reativa para rastrear o status de autenticação
const isLoggedIn = ref(false);
// Criar propriedades reativas para controlar a visibilidade do modal
const showLoginModal = ref(false);
const showRegistrationModal = ref(false);
const userId = ref(localStorage.getItem('userId')); // Definir userId diretamente do localStorage

// Chamar o método checkAuthentication quando o componente for montado
isLoggedIn.value = checkAuthentication();

// Método para lidar com o login
const login = () => {
  showLoginModal.value = true;
};

// Método para lidar com o logout
const logout = async () => {
  try {
    // Fetch the CSRF cookie
    await axiosInstance.get('/sanctum/csrf-cookie');

    // Fazer uma solicitação para o endpoint de logout com o token de autorização
    await axiosInstance.post('/auth/logout', null, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('accessToken')}`,
      },
    });
    
    // Limpar o token do armazenamento local
    localStorage.removeItem('accessToken');
    localStorage.removeItem('userId');
    
    // Atualizar o status isLoggedIn
    isLoggedIn.value = checkAuthentication();

    eventBus.emit('logout');

    // Você também pode executar qualquer outra lógica aqui, como redirecionar o usuário ou atualizar a interface do usuário
  } catch (error) {
    console.error('Error logging out:', error);
    // Lidar com erro de logout
  }
};

// Método para lidar com o registro
const register = () => {
  showRegistrationModal.value = true;
};

// Método para lidar com o login
const handleLoggedIn = () => {
  isLoggedIn.value = checkAuthentication();
  userId.value = localStorage.getItem('userId'); // Atualizar userId do localStorage
};

// Método para lidar com o registro
const handleRegistered = () => {
  isLoggedIn.value = checkAuthentication();
  userId.value = localStorage.getItem('userId'); // Atualizar userId do localStorage
};

// Escutar pelo evento de exclusão do usuário
eventBus.on('userDeleted', () => {
  // Verificar se o usuário está logado
  isLoggedIn.value = checkAuthentication();
});
</script>
