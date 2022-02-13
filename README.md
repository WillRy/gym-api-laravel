# API Laravel com JWT (ainda em construção)

Repositório contem exemplo de autenticação JWT seguindo os padrões do Laravel, usando

- Eloquent para models
- Auth Guard para autenticação e segurança


## Explicação do sistema

- A academia pode cadastrar planos da academia
- A academia pode cadastrar alunos
- A academia pode cadastrar matrículas(vinculando o aluno em um plano da academia)


## FrontEnd

O frontend é uma SPA feita em VueJS, no repositório:
[https://github.com/WillRy/gym-spa-laravel](https://github.com/WillRy/gym-spa-laravel)


## Implementação

- Auth Guard personalizada em "config/auth.php", chamada de "api"
- Rotas de autenticação em "routes/api.php"
- Controller em "app/Http/Controllers/AuthController"

## Endpoints

- Basta importar o arquivo "endpoints-insomnia.json" no
  client HTTP insomnia ou postman

## Como executar?

- Baixar o projeto
- Executar composer para instalar dependencias
- Criar .env com base no .env.example e configurar credencial do banco de dados no .env
- Executar migration e seed dos dados. Migration cria a estrutura do banco de dados e seed popula com dados.

**Comandos que devem ser executados:**
```shell
#instalar dependencias do composer
composer install

#configura criptografia do laravel
php artisan key:generate

#configura criptografia dos tokens JWT
php artisan jwt:secret

#executa migrations e seed
php artisan migrate:fresh --seed

```

**Executar servidor**

Você pode usar o ambiente docker ou usar o servidor embutido do laravel.

Servidor embutido:

```shell
php artisan serve --port=8000
```

## Ambiente docker

Este repositório contém um ambiente docker, basta executar os comandos:

```shell
sudo chmod 777 -R docker/

docker-compose up -d 
```

Acessar a URL

[http://localhost:8000](http://localhost:8000)
