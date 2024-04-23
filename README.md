# NewBlog
Uma sistema de blogging simples usando **Vue.js**, e uma API REST em **Laravel**. 
## Índice:
1. **[Introdução](#introdução)**
2. **[Tech Stack](#Tech-Stack)**
3. **[Instalação](#instalação)**
4. **[Documentação da API](#documentação-da-api)**
## Introdução:
NewBlog é um sistema de blogging simples, que permite o usuário autenticado criar posts e comentários.
Além disso a aplicação permite os usuários vizualizarem o próprio perfil assim como o de outros usuários,
bem como uma lista com todas as postagens disponíveis.
## Tech Stack:
Ferramentas e versões usadas no projeto:
### Front-end
- Vue.js
- Tailwind CSS
- Mitt
- Axios
### Back-end
- PHP 8.3
- Laravel 11.0.7
- MySql 8.0
- Composer 2.6.5
- Sanctum
### Utilitários
- Editor De Texto:  **[Visual Studio Code](https://code.visualstudio.com/)**
- Banco De Daddos: MySqlWorkBench
- API Client : **[Insonia](https://insomnia.rest/)**
  
## Instalação:
### Pré-requisitos
- Node.js
- NPM
- PHP 8.3
- MySQL 8.0
- Composer 2.6.5
### Clonando o Repositório
```bash
# Clone este repositório
$ git clone https://github.com/basedCaesar/NewBlog.git
# Navegue até a pasta 
$ cd NewBlogProject
```
### Front-end(Vue)
```bash
# Navegue até a pasta que contém o front-end
$ cd front-end
# Instale as dependências
$ npm install
# Execute a aplicação
$ npm run dev
#clique no link do servidor que foi gerado
```
### Backend (Laravel + MySql)
```bash
# Navegue até a pasta que contém o back-end
$ cd back-end
# Instale as dependências
$ composer install
# Mude o arquivo `.env.example` para `.env` e configure suas variáveis de ambiente.
# Crie uma base de dados chamado blogdb
# Gere uma chave de aplicativo.
$ php artisan key:generate
# Execute as migrations
$ php artisan migrate
# Execute a aplicação em modo de desenvolvimento
$ php artisan serve
#click no link do servidor que foi gerado
```
## Documentação da API:
### End points da API
| Método    | URL                 | Descrição                  | Requer autenticação                  |
| ---------- | ------------------- | ---------------------------- |-------------------------|
| `POST`    | api/auth/register          | Registra um novo usuário   |Não|
| `POST`   | api/auth/login              | Realiza login do usuário    |Não|
| `POST`    | api/auth/logout    | Realiza logout do usuário |Sim|
| `GET`    | api/posts | Recupera todos os posts do BDD |Não|
| `GET` | /api/posts/{id}       | Recupera um post específico do BDD |Não|
| `POST`    | api/posts    | Cria um novo post no BDD |Sim|
| `PUT`    | api/posts/{id}    | Altera um post específico no BDD |Sim|
| `DELETE`    | api/posts/{id}    | Deleta um post específico no BDD |Sim|
| `POST`    | api/posts/{id}/comments    | Cria um novo comentário em um post específico |Sim|
| `GET`    | api/posts/{id}/comments | Recupera todos os comentários de um post específico|Não|
| `GET`    | api/user/{id} | Recupera o perfil de um usuário específico|Não|
| `PUT`    | api/user/{id} | Altera o perfil de um usuário específico|Sim|
| `DELETE`    | api/user/{id} |Deleta o perfil de um usuário específico|Sim|
