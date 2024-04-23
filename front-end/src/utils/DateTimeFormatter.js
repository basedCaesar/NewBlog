// Método para formatar a data e hora
export const formatDateTime = (timestamp) => {
  const date = new Date(timestamp); // Criar um objeto Date a partir do timestamp
  
  // Obter horas e minutos
  const hours = date.getHours().toString().padStart(2, '0'); // Obter as horas e garantir que tenha dois dígitos, preenchendo com zero à esquerda, se necessário
  const minutes = date.getMinutes().toString().padStart(2, '0'); // Obter os minutos e garantir que tenha dois dígitos, preenchendo com zero à esquerda, se necessário
  
  // Obter dia, mês e ano
  const day = date.getDate().toString().padStart(2, '0'); // Obter o dia e garantir que tenha dois dígitos, preenchendo com zero à esquerda, se necessário
  const month = (date.getMonth() + 1).toString().padStart(2, '0'); // Obter o mês (lembrando que os meses são indexados em zero, então é necessário adicionar 1) e garantir que tenha dois dígitos, preenchendo com zero à esquerda, se necessário
  const year = date.getFullYear(); // Obter o ano
  
  // Construir a string formatada de data e hora
  return `${hours}:${minutes} - ${day}/${month}/${year}`;
};

  