<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo"></a></p>

<!-- <p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

<h1 align="center">Base API Laravel</h1>

Este repositório serve como uma base robusta e padronizada para iniciar novos projetos de API com Laravel 10+. Ele inclui configurações essenciais e segue as melhores práticas para desenvolvimento de APIs escaláveis e de alta performance. -->

## Estrutura do Projeto e Tecnologias

Este projeto é configurado com as seguintes tecnologias e padrões:

- **PHP**: Linguagem principal, com foco em Laravel 10+.
- **Docker Compose**: Para ambientes de desenvolvimento padronizados e reprodutíveis (incluindo Nginx, PHP-FPM, MySQL, Redis).
- **PestPHP**: Framework de testes para PHP (unitários e de feature).

## Requisitos

- Docker
- Docker Compose
- Git

## Primeiros Passos

Siga os passos abaixo para configurar e executar o projeto em seu ambiente local:

1. **Clone o repositório:**

   ```bash
   git clone <URL_DO_SEU_REPOSITORIO>
   cd base-api
   ```

2. **Inicie os serviços Docker:**

   ```bash
   docker compose up -d --build
   ```

   Isso irá construir as imagens (se necessário) e iniciar os contêineres para Nginx, PHP-FFPM, MySQL e Redis.
   Após o processo de criação dos conteineres, o script shell é executado e já deixa o ambiente todo pronto,
   desde copiar o env exemplo a iniciar o supervisor para rodar as queues.


4. **Acesse a aplicação:**

   A API estará disponível em `http://localhost`.
