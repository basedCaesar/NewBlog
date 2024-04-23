import { useRoute } from 'vue-router';

// Método para verificar a propriedade do perfil
export const checkOwnership = () => {
    const route = useRoute(); // Obter o objeto de rota atual
    const userIdFromUrl = parseInt(route.params.userId); // Converter o parâmetro de ID do usuário da URL para um número inteiro
    const userIdFromLocalStorage = localStorage.getItem('userId'); // Obter o ID do usuário armazenado no localStorage
    // Verificar se o ID do usuário da URL é o mesmo que o ID do usuário armazenado no localStorage
    return userIdFromUrl === parseInt(userIdFromLocalStorage);
};
