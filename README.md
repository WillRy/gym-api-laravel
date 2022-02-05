# API Laravel com JWT

Repositório contem exemplo de autenticação JWT seguindo os padrões do Laravel, usando

- Eloquent para models
- Auth Guard para autenticação e segurança


## Implementação

- Auth Guard personalizada em "config/auth.php", chamada de "api"
- Rotas de autenticação em "routes/api.php"
- Controller em "app/Http/Controllers/AuthController"

## Endpoints

- Basta importar o arquivo "endpoints-insomnia.json" no
  client HTTP insomnia ou postman

## Como executar

- Baixar o projeto
- Criar .env com base no .env.example e configurar credencial do banco de dados no .env
- Executar migration e seed dos dados. Migration cria a estrutura do banco de dados e seed popula com dados.

**Executar migrations e seeds**
```shell
php artisan migrate:fresh --seed
```


## Ambiente docker

Este repositório contém um ambiente docker, basta executar os comandos:

```shell
sudo chmod 777 -R docker/

docker-compose up -d 
```

Acessar a URL

[http://localhost:8000](http://localhost:8000)
