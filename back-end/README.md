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

<details>
<summary>Rotas de autenticação</summary>



### POST "Registra um novo usuário"

- **URL:** `api/auth/register`
- **Método:** POST
- **Descrição:** Registra um novo usuário no BDD.
- **Parâmetros:**
  - `name`: Nome do usuário. 
  - `email`: Email do usuário.
  - `password`: Senha do usuário.
- **Headers:**

- **Resposta:**
  ```json
  {
	"token": <"Token gerado na criação do usuário">,
	"user": {
		"name": <"Nome do usuário">,
		"email": <"Email do usuário">,
		"updated_at": <"Data/hora da alteração">,
		"created_at": <"Data/hora da criação">,
		"id": <id>
	    }
  }
  ```

  ### POST "Realiza logout do usuário"

- **URL:** `api/auth/logout`
- **Método:** POST
- **Descrição:** Realiza login do usuário.
- **Parâmetros:**
- **Headers:**
 - `Authorization`: Bearer <Token>.
- **Resposta:**
  ```json
  {
	"message": "Logout realizado com sucesso"
  }
  ```
  
  ### POST "Realiza login do usuário"

- **URL:** `api/auth/login`
- **Método:** POST
- **Descrição:** Realiza login do usuário.
- **Parâmetros:**
  - `email`: Email do usuário.
  - `password`: Senha do usuário.
- **Resposta:**
  ```json
  {
	"token": <"Token gerado no login do usuário">,
	"user": {
		"name": <"Nome do usuário">,
		"email": <"Email do usuário">,
		"updated_at": <"Data/hora da alteração">,
		"created_at": <"Data/hora da criação">,
		"id": <id>
	}
}
  ```


</details>



<details>

<summary>Rotas dos posts</summary>
    

   ### PUT "Altera um post específico no BDD"

- **URL:** `api/v1/tarefas/{id}`
- **Método:** PUT
- **Descrição:** Altera um post específico no BDD.
- **Parâmetros:**
  - `title`: Título do post. 
  - `content`: Conteúdo do post.
- **Headers:**
   - `Authorization`: Bearer <Token>.
- **Resposta:**
  ```json
  {
        "id": <Id do post>
		"title": <"Título atualizado do post">,
		"content": <"Conteúdo atualizado do post">,
		"user_id": <Id do usuário>,
		"created_at": <"Data/hora da criação">,
		"updated_at": <"Data/hora da alteração">
  }
  ```

 

 ### DELETE "Deleta um post específico no BDD"

- **URL:** `api/posts/{id}`
- **Método:** DELETE
- **Descrição:** Deleta um post específico no BDD.
- **Parâmetros:**
- **Headers:**
   - `Authorization`: Bearer <Token>.
- **Resposta:**
  ```json
  {
  }
  ```

</details>


<details>
<summary>Rotas dos comentários</summary>
    
### POST "Cria um novo comentário em um post específico"

- **URL:** `api/posts/{id}/comments`
- **Método:** POST
- **Descrição:**  Deleta um post específico no BDD.
- **Parâmetros:**
  - `content`: Conteúdo do comentário.
- **Headers:**
   - `Authorization`: Bearer <Token>.
- **Resposta:**
  ```json
  {
			
		
		"content": <"Conteúdo do comentário">,
		"user_id": <Id do usuário>, 
		"blog_post_id": <Id do post>, 
		"created_at": <"Data/hora da criação">,
		"updated_at": <"Data/hora da alteração">
        "id": <Id do comentário>

  }
  ```

  
### GET "Recupera todos os comentários de um post específico"

- **URL:** `api/posts/{id}/comments`
- **Método:** GET
- **Descrição:** Recupera todos os comentários de um post específico.
- **Parâmetros:**
- **Headers:**
- **Resposta:**
  ```json
  {
	[
	{
			
		
        "id": <Id do comentário>
		"content": <"Conteúdo do comentário">,
		"user_id": <Id do usuário>, 
		"blog_post_id": <Id do post>, 
		"created_at": <"Data/hora da criação">,
		"updated_at": <"Data/hora da alteração">
    }
]
}
```
### GET "Recupera todos os posts do BDD"

- **URL:** `api/posts`
- **Método:** GET
- **Descrição:** Recupera todos os posts do BDD.
- **Parâmetros:**
- **Headers:**
- **Resposta:**
  ```json
  {
	[
	{
		"id": <Id do post>,
		"title": <"Título do post">,
		"content": <"Conteúdo do post">,
		"user_id": <Id do usuário>,
		"created_at": <"Data/hora da criação">,
		"updated_at": <"Data/hora da alteração">
	},
	{
		"id": <Id do post>,
		"title": <"Título do post">,
		"content": <"Conteúdo do post">,
		"user_id": <Id do usuário>,
		"created_at": <"Data/hora da criação">,
		"updated_at": <"Data/hora da alteração">
	},
  {
		"id": <Id do post>,
		"title": <"Título do post">,
		"content": <"Conteúdo do post">,
		"user_id": <Id do usuário>,
		"created_at": <"Data/hora da criação">,
		"updated_at": <"Data/hora da alteração">
	}
]
}
```

    
### GET "Recupera um post específico do BDD"

- **URL:** `api/posts/{id}`
- **Método:** GET
- **Descrição:** Recupera um post específico do BDD.
- **Parâmetros:**
- **Headers:**
- **Resposta:**
  ```json
  {

	{
		"id": <Id do post>,
		"title": <"Título do post">,
		"content": <"Conteúdo do post">,
		"user_id": <Id do usuário>,
		"created_at": <"Data/hora da criação">,
		"updated_at": <"Data/hora da alteração">
	}

}
```

### POST "Cria um novo post no BDD"

- **URL:** `api/posts`
- **Método:** POST
- **Descrição:** Cria um novo post no BDD.
- **Parâmetros:**
  - `title`: Título do post. 
  - `content`: Conteúdo do post.
- **Headers:**
   - `Authorization`: Bearer <Token>.
- **Resposta:**
  ```json
  {
			
		
		"title": <"Título do post">,
		"content": <"Conteúdo do post">,
		"user_id": <Id do usuário>,
		"created_at": <"Data/hora da criação">,
		"updated_at": <"Data/hora da alteração">
        "id": <Id do post>

  }
  ```

</details>

<details>
<summary>Rotas dos perfis</summary>
    
### GET "Recupera o perfil de um usuário específico"

- **URL:** `api/user/{id}`
- **Método:** GET
- **Descrição:** Recupera o perfil de um usuário específico.
- **Parâmetros:**
- **Headers:**
- **Resposta:**
  ```json
  {
	"id": <Id do usuário>,
	"name": <"Nome do usuário">,
	"email": <"Email do usuário">,
	"email_verified_at": null,
	"created_at": <"Data/hora de criação do usuário">,
	"updated_at": <"Data/hora de alteração do usuário">,
	"posts": [
		{
			"id": <Id do comentário>,
            "title": <"Título do post">,
            "content": <"Conteúdo do comentário">,
    		"user_id": <Id do usuário>, 
    		"created_at": <"Data/hora da criação">,
    		"updated_at": <"Data/hora da alteração">
        },
      {
			"id": <Id do comentário>,
            "title": <"Título do post">,
            "content": <"Conteúdo do comentário">,
    		"user_id": <Id do usuário>, 
    		"created_at": <"Data/hora da criação">,
    		"updated_at": <"Data/hora da alteração">
        }
		
	]
}

```

### PUT "Altera o perfil de um usuário específico"

- **URL:** `api/user/{id}`
- **Método:** PUT
- **Descrição:** Altera o perfil de um usuário específico.
- **Parâmetros:**
  - `name`: Novo nome do usuário. 
  - `email`: Novo email do usuário.
- **Resposta:**
  ```json
  
       {
	"message": "Perfil atualizado com sucesso"
}
  
  ```

### DELETE "Deleta o perfil de um usuário específico"

- **URL:** `api/posts/{id}`
- **Método:** DELETE
- **Descrição:** Deleta o perfil de um usuário específico.
- **Parâmetros:**
- **Headers:**
   - `Authorization`: Bearer <Token>.
- **Resposta:**
  ```json
  {
  "message": "Conta excluída com sucesso"
  }
  ```

</details>
