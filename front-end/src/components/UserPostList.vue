<template>
  <!-- Container para exibir os posts do usuário -->
  <div class="user-posts mt-8">

    <!-- Título dos posts do usuário -->
    <h2 class="text-2xl font-semibold mb-4 inline-block">Posts</h2>

    <!-- Botão para criar um novo post -->
    <button v-if="isLoggedIn && isOwnProfile" @click="navigateToNewPost" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1 px-2 rounded-full ml-4">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-4 h-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
      </svg>
    </button>

    <!-- Contêiner que apresenta as postagens e formato de cartões -->
    <div class="flex flex-col space-y-4">

      <!-- Iteração pelos posts do usuário -->
      <div v-for="post in posts" :key="post.id" class="card bg-white shadow-lg rounded-lg overflow-hidden cursor-pointer" @click="navigateToPost(post.id)">
        
        <!-- Cabeçalho do post -->
        <div class="card-header p-4 bg-gray-800 text-white text-center">
          <h3 class="text-lg font-semibold">{{ post.title }}</h3>
        </div>
        
        <!-- Conteúdo do post e botões de deletar e alterar-->
        <div class="card-content p-4 border-t-0 border-l border-r border-b border-black rounded-b-lg  break-all">
          <p class="max-h-32 overflow-hidden text-gray-600" style="line-height: 1.6rem;">{{ post.content }}</p>
        
        <!-- Ações do cartão para deletar e alterar -->
        <div v-if="isOwnProfile" class="card-actions p-4">
          <!-- Botão para deletar o post -->
          <button @click.stop="deletePost(post.id)" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-1 px-2 rounded-full ml-4">
            Excluir
          </button>
          <!-- Botão para alterar o post -->
          <button @click.stop="handleAlterPost(post.id, post.title, post.content)" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-1 px-2 rounded-full ml-4">
            Alterar
          </button>
        </div>

      </div>
      </div>
    </div>

    <!-- Modal para alterar conteúdo ou título do post -->
    <alterPostModal v-if="showAlterPostModal" :postId="modalPostId" :initialTitle="modalPostTitle" :initialContent="modalPostContent" @close="closeAlterPostModal()" @altered="reloadPage()" />
  </div>
</template>

  
  <script setup>

  //Importando funções e componentes relevantes
  import { defineProps, onBeforeMount, ref } from 'vue';
  import { useRouter } from 'vue-router';
  import { checkAuthentication } from '../utils/auth';
  import { checkOwnership } from '../utils/CheckOwnership.js';
  import alterPostModal from './modals/AlterPostModal.vue';
  import axios from 'axios';
  
  //Declarando constantes reativas para controle de estilos e funções
  const isLoggedIn = ref(null);
  const isOwnProfile = ref(checkOwnership());
  const showAlterPostModal = ref(false);
  const modalPostId = ref('');
  const modalPostTitle = ref('');
  const modalPostContent = ref('');
  
  //Declarando router
  const router = useRouter();

  // Definindo props que serão recebidos do componente pai
  const props = defineProps({
    posts: {
      type: Array,
      required: true
    },
    isOwnProfile: {
      type: Boolean,
      required: true
    }
  });
  
  // Usando a hook onBeforeMount para mudar o valor de isLoggedIn antes de montar o componente
  onBeforeMount(() => {
    // Chamando checkAuthentication() para determinar o status de autenticação
    isLoggedIn.value = checkAuthentication();
  });

  // Função para navegar para a rota PostDetail
  const navigateToPost = (postId) => {
    router.push(`/posts/${postId}`);
  };

  // Função para navegar para a rota CreatePost
  const navigateToNewPost = () => {
    router.push('/posts/create'); 
  };
 
  // Função para dar reload na página, quando um post é deletado ou alterado
  const reloadPage = () => {
    router.go();
  };

  // Função para deletar um post
  const deletePost = async (postId) => {
    try {
      // Pega o token do local storage
      const token = localStorage.getItem('accessToken');

      // Faz a request de deleção passando o header 'authorization' 
      await axios.delete(`http://127.0.0.1:8000/api/posts/${postId}`, {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });

      // Chama função para dar reload na página
      reloadPage();
      
    } catch (error) {
      console.error('Erro ao deletar post:', error);
    
    }
  };

  // Função para abrir o modal de alteração e passar os valores necessários para as props 
  const handleAlterPost = (postId, postTitle, postContent) => {
    modalPostId.value = postId;
    modalPostTitle.value = postTitle;
    modalPostContent.value = postContent;
    showAlterPostModal.value = true;
  };

  // Função para fechar o modal de alteração
  const closeAlterPostModal = () => {
    showAlterPostModal.value = false;
  };
  </script>
  
