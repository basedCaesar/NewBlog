<template>
  <!-- Container para exibir as informações do usuário -->
  <div class="user-info bg-gray-100 p-4 rounded-lg">
    <!-- Título da seção -->
    <h2 class="text-2xl font-semibold mb-4">Perfil do Usuário</h2>
    <!-- Detalhes do usuário -->
    <div class="user-details">
      <!-- Nome do usuário -->
      <h3 class="text-xl font-semibold">{{ user.name }}</h3>
      <!-- E-mail do usuário -->
      <p class="text-gray-600">{{ user.email }}</p>
    </div>
    <!-- Mostrar ações da conta apenas se o usuário estiver logado e visualizando seu próprio perfil -->
    <div v-if="isOwnProfile" class="actions mt-4">
      <!-- Botão para excluir a conta -->
      <button @click="deleteAccount" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded mr-2">Excluir Conta</button>
      <!-- Botão para editar a conta -->
      <button @click="editAccountModal" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">Editar Conta</button>
    </div>
  </div>

  <!-- Modal para edição do usuário -->
  <EditUserModal v-if="showEditUserModal" @close="showEditUserModal = false" @altered="reloadUserInfo()" :initialName="user.name" :initialEmail="user.email"/>
</template>

<script setup>
import { defineProps, ref } from 'vue';
import axiosInstance from '../utils/axiosInstance.js';
import eventBus from '../utils/EventBus.js'; 
import { checkOwnership } from '../utils/CheckOwnership'; 
import EditUserModal from './modals/EditUserModal.vue';
import { useRouter } from 'vue-router';

const router = useRouter(); // Obter a instância do router

const showEditUserModal = ref(false);
// Definir props para receber o objeto do usuário e o status de autenticação
const props = defineProps({
  user: {
    type: Object,
    required: true
  }
});

const isOwnProfile = ref(checkOwnership());

// Método para excluir a conta do usuário
const deleteAccount = async () => {
  try {
    // Fetch the CSRF cookie
    await axiosInstance.get('/sanctum/csrf-cookie');

    // Obter o token do armazenamento local
    const token = localStorage.getItem('accessToken');

    // Fazer uma solicitação para excluir a conta com o cabeçalho de autorização
    await axiosInstance.delete(`/user/profile/${props.user.id}`, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });

    // Limpar o token do armazenamento local
    localStorage.removeItem('accessToken');
    localStorage.removeItem('userId');
    eventBus.emit('userDeleted');

    // Redirecionar para a página inicial
    router.push('/');

    // Mostrar um alerta
    alert('Conta excluída com sucesso');

  } catch (error) {
    console.error('Erro ao excluir conta:', error);
    // Lidar com o erro
  }
};

// Método para abrir o modal de edição de conta
const editAccountModal = () => {
  showEditUserModal.value = true;
};

// Escutar o evento de logout
eventBus.on('logout', () => {
  isOwnProfile.value = checkOwnership(); // Redefinir isOwnProfile para false quando o usuário faz logout
});

// Método para recarregar as informações do usuário após a edição
const reloadUserInfo = async () => {
  // Buscar os dados atualizados do usuário e atualizar os props
  try {
    const response = await axiosInstance.get(`/user/${props.user.id}`);
    props.user = response.data; // Supondo que a resposta contenha o objeto de usuário atualizado
    window.location.reload(); // Recarregar a página
  } catch (error) {
    console.error('Erro ao buscar dados do usuário:', error);
  }
};

</script>



<style scoped>

.actions {
  display: flex;
  justify-content: center;
}
.actions button {
  margin-right: 8px;
}
</style>
