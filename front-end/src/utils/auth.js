// Função para verificar o status de autenticação
export const checkAuthentication = () => {
    // Verifica se o token de autenticação existe no localStorage
    const accessToken = localStorage.getItem('accessToken');
    // Retorna true se o token existir, indicando que o usuário está autenticado
    return !!accessToken;
};

