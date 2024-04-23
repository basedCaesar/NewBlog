import { createRouter, createWebHistory } from 'vue-router';

import UserProfile from '../views/UserProfile.vue';
import PostDetail from '../views/PostDetail.vue';
import CreatePost from '../views/CreatePost.vue';
import Home from '../views/Home.vue';
import { checkAuthentication } from '../utils/auth';

// Criação do roteador utilizando o Vue Router
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL), // Cria o histórico de navegação baseado no URL da aplicação
  routes: [
    {
      path: '/', // Define o caminho para a rota inicial
      name: 'Home', // Nome da rota
      component: Home // Componente associado à rota
    },
    {
      path: '/profile/:userId', // Define o caminho para o perfil do usuário com parâmetro dinâmico userId
      name: 'UserProfile', // Nome da rota
      component: UserProfile // Componente associado à rota
    },
    {
      path: '/posts/:postId', // Define o caminho para detalhes de postagens com parâmetro dinâmico postId
      name: 'PostDetail', // Nome da rota
      component: PostDetail // Componente associado à rota, responsável por exibir detalhes da postagem
    },
    {
      path: '/posts/create', // Define o caminho para criar uma nova postagem
      name: 'CreatePost', // Nome da rota
      component: CreatePost, // Componente associado à rota
      beforeEnter: (to, from, next) => { // Função executada antes de entrar na rota
        // Verifica se o usuário está autenticado
        if (!checkAuthentication()) {
          // Alerta o usuário se não estiver autenticado
          alert('Você precisa estar logado para acessar esta página.');
          // Redireciona para a página principal se não estiver autenticado
          next('/');
        } else {
          // Continua para a página de criação de postagem se estiver autenticado
          next();
        }
      }
    }
  ]
});

export default router;
