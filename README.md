# Projeto para Gerenciamento de RH
## Laravel com Docker (PHP 8.3 + Nginx + MySQL + Redis + Mailhog)

Este repositório contém um projeto **Laravel** que simula o pricípio do que seria um sistema para gerenciamento do
departamento de recursos humanos. É configurado para rodar em **Docker** no **Ubuntu** utilizando um ambiente completo com:

- PHP 8.3 (FPM)  
- Nginx  
- MySQL 5.7  
- Redis  
- Mailhog  
- PHPMyAdmin  

## Pré-requisitos

Antes de começar, certifique-se de ter instalado:

- [Docker](https://docs.docker.com/get-docker/)  
- [Docker Compose](https://docs.docker.com/compose/install/)  


## Configuração inicial

1. **Clone o repositório**\
   git clone https://github.com/seu-usuario/seu-projeto.git
   cd seu-projeto
Copie o arquivo .env.example para .env\
cp .env.example .env\
Configure as variáveis de ambiente no .env

2. **Ajuste para usar os containers definidos no docker-compose.yml**:
DB_CONNECTION=mysql\
DB_HOST=db\
DB_PORT=3306\
DB_DATABASE=rh\
DB_USERNAME=username\
DB_PASSWORD=userpass

3. **Configure o envio de e-mails com Mailhog ou o serviço de sua preferência**:
MAIL_MAILER=smtp\
MAIL_HOST=mailhog\
MAIL_PORT=1025\
MAIL_USERNAME=null\
MAIL_PASSWORD=null\
MAIL_ENCRYPTION=null\
MAIL_FROM_ADDRESS=example@example.com\
MAIL_FROM_NAME="${APP_NAME}"

4. **Suba os containers** 
Construa e inicie os serviços:\
docker-compose up -d --build

5. **Instalação de dependências**
Entre no container app e rode o composer:\
docker-compose exec app composer update\

6. **Banco de Dados**
Após os containers estarem ativos, rode:\
docker-compose exec app php artisan migrate\
docker-compose exec app php artisan db:seed --class=AdminSeeder

## Geração da chave da aplicação
Se necessário, gere a chave do Laravel:\
docker-compose exec app php artisan key:generate

## Testando envio de e-mails
Interface do Mailhog: http://localhost:8025

## Acessando serviços do ambiente
- Aplicação Laravel: http://localhost:8989
- PHPMyAdmin: http://localhost:8080
- Mailhog: http://localhost:8025
- Acessar aplicação com email e senha definidos no AdminSeeder.php

## Regras de negócio:
Sistema tem basicamente três tipos de utilizadores:
- Admin (Cadastra, edita, visualiza e exclui colaboradores normais e colaboradores de RH)
- RH (Cadastra, edita, visualiza e exclui outros colaboradores, com exceção do RH)
- Colaborador (Apenas visualiza seus próprios dados)
