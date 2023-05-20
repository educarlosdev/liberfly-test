## Teste realizado para Liberfly

O teste consiste em desenvolver uma API Restful com PHP e Laravel incluindo autenticação JWT.
Foi implementado um CRUD de Categorias, onde conseguimos listar as categorias com paginação somente cadastradas pelo usuário, permitindo nessa listagem também filtrar por nome. Também foi implementado o cadastro, edição e deleção somente das categorias do usuário autenticado e também exibir um unico registro através do seu id.

- [Ambiente de produção](https://liberfly.eduardocarlos.com.br).
- [GitHub](https://github.com/educarlosdev/liberfly-test).

# Pré-requisitos
- PHP 8.2
- Laravel 10
- Docker
- Docker Compose
- Git
- Composer

## Execução do projeto manual
Execute os passos abaixo:

- git clone https://github.com/educarlosdev/liberfly-test
- cd liberfly-test
- composer update
- cp .env.example .env
- configure o DB_HOST, APP_URL e afins no .env
- php artisan key:generate
- php artisan migrate --seed
- php artisan serve

## Execução do projeto com Docker
Execute os passos abaixo:

- git clone https://github.com/educarlosdev/liberfly-test
- cd liberfly-test
- configure o DB_HOST, APP_URL e afins no .env
- docker-compose up -d

## Usuário e senha padrão para autenticar na API de teste
### Documentação via Swagger
- email: test@example.com
- password: password
