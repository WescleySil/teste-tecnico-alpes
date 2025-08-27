# 🚗 API de Anúncios de Veículos

<div align="center">

![Tecnologias](https://skillicons.dev/icons?i=laravel,docker,mysql,aws,github,actions)

</div>

## 📋 Sobre o Projeto

Esta é uma API RESTful construída com Laravel, projetada para gerenciar anúncios de veículos. O sistema oferece funcionalidades para criar, listar, atualizar e deletar usuários, veículos e seus respectivos anúncios.

### 🎯 Principais Funcionalidades

- ✨ API RESTful robusta e bem estruturada
- 👥 Gerenciamento completo de usuários
- 🚗 Gerenciamento de veículos
- 📢 Gerenciamento de anúncios de veículos
- 🔐 Autenticação segura com Laravel Sanctum

## 🛠️ Tecnologias Utilizadas

### Backend

- **Framework**: Laravel 12 (PHP)
- **Banco de Dados**: MySQL (via Docker)
- **Conteinerização**: Docker
- **Testes**: PestPHP
- **Autenticação**: Laravel Sanctum

## 📦 Plataformas Utilizadas

- **GitHub**: Hospedagem do código-fonte.
- **GitHub Actions**: CI/CD para deploy automático na AWS a cada push na branch `main`.
- **AWS**: Hospedagem da aplicação em uma instância EC2.
- **DuckDNS**: Gerenciamento de DNS para o domínio da aplicação.
- **Certbot**: Geração e renovação de certificados SSL/TLS.

## 🚀 CI/CD Pipeline

O projeto conta com um pipeline de Integração e Entrega Contínua (CI/CD) configurado com o GitHub Actions, que automatiza o processo de deploy para o ambiente de produção na AWS.

### Como funciona:

1.  **Gatilho**: O pipeline é acionado automaticamente a cada `push` para a branch `main`.
2.  **Conexão SSH**: O GitHub Actions se conecta de forma segura à instância EC2 na AWS utilizando chaves SSH armazenadas nos Secrets do repositório.

    ![Configuração das Secrets no GitHub Actions](https://i.ibb.co/WWD2c37g/Captura-de-tela-2025-08-27-122018.png)
3.  **Deploy**: 
    *   O script de deploy verifica se o repositório já existe no servidor.
    *   Se existir, ele atualiza o código com as últimas alterações da branch `main` e reinicia os serviços com `docker compose down` e `docker compose up -d`.
    *   Caso contrário, ele clona o repositório pela primeira vez e sobe os serviços com `docker compose up -d`.
    *   [Veja o script de deploy aqui](./.github/scripts/deploy.sh)

Isso garante que o ambiente de produção esteja sempre sincronizado com a versão mais recente do código na branch principal, de forma automatizada e segura.

## 🚀 Como Executar o Projeto

### Pré-requisitos

- 🐳 Docker e Docker Compose
- 📦 Git

### 🔧 Instalação (Desenvolvimento Local)

1. **Clone o repositório**

```bash
git clone https://github.com/WescleySil/teste-tecnico-alpes.git
cd teste-tecnico-alpes
```

2. **Suba os containers do Docker**

```bash
docker compose -f docker-compose-dev.yml up -d
```

> ⚠️ Aguarde alguns instantes para que o container do Laravel configure tudo automaticamente.

## 📍 Acessando a API

### [🔗 Desenvolvimento Local](http://localhost)

### [🚀 Produção](https://teste-tecnico-alpes.duckdns.org/)

> ⚠️ **Observação (Desenvolvimento Local):** Caso você encontre um erro "502 Bad Gateway" ao acessar a API pela primeira vez, aguarde cerca de 2 minutos e recarregue a página. Isso ocorre porque o container está executando o script `startup.sh` em segundo plano, que realiza a instalação das dependências do Composer e outras configurações iniciais.

> ⚠️ **Observação (Produção):** Caso a URL de produção não esteja respondendo, por favor, entre em contato. A instância na AWS tem apresentado um erro de conexão intermitente (geralmente durante a madrugada) que exige uma reinicialização manual.

## 📥 Comando de Importação de Dados

O projeto inclui um comando Artisan para importar dados de veículos de uma fonte externa.

### Como funciona:

O comando `vehicle:import-data` busca os dados de um endpoint JSON, processa as informações e as insere no banco de dados. O processo é realizado dentro de uma transação para garantir a consistência dos dados. Para cada veículo, o comando:

1.  Cria ou atualiza o registro do **veículo**.
2.  Cria ou atualiza o **anúncio** associado ao veículo.
3.  Cria ou atualiza as **fotos** do anúncio.

### Como executar:

1.  **Acesse o container da aplicação:**

    ```bash
    docker exec -it app_development bash
    ```

2.  **Execute o comando de importação:**

    ```bash
    php artisan vehicle:import-data
    ```

    Ao final da execução, você verá uma mensagem de sucesso ou de erro no console.

## 🧪 Executando os Testes

O projeto inclui testes automatizados para garantir a qualidade do código. Para executar os testes:

```bash
# Acesse o container do Laravel
docker exec -it app_development bash

# Execute todos os testes
php artisan test

# ou para ver os testes com mais detalhes
php artisan test --testdox
```

Os testes incluem:
- ✅ Testes de Feature para as rotas da API
- ✅ Testes de autenticação
- ✅ Testes de CRUD para os principais recursos

> 💡 Os testes são executados em um banco de dados separado para não afetar seus dados de desenvolvimento.

## ⚙️ Configuração em Produção (Instância EC2)

A configuração do ambiente de produção é feita de forma automatizada pelo pipeline de CI/CD. No entanto, caso seja necessário configurar manualmente a aplicação em uma instância EC2, siga os passos abaixo:

1.  **Acesse a instância EC2** via SSH.
2.  **Clone o repositório:**
    ```bash
    git clone https://github.com/WescleySil/teste-tecnico-alpes.git
    cd teste-tecnico-alpes
    ```
3.  **Suba os containers Docker:**
    Este comando utilizará o arquivo `docker-compose.yml` padrão, que é configurado para o ambiente de produção.
    ```bash
    docker compose up -d
    ```
    Os serviços, incluindo a aplicação, o banco de dados e o Nginx, serão iniciados.

> ⚠️ **Observação:** A execução do `docker compose up -d` disponibilizará a aplicação via HTTP. A configuração do certificado HTTPS com Certbot e o direcionamento de DNS com o DuckDNS são processos separados. Além disso, a configuração do Nginx no `docker-compose.yml` de produção está diretamente ligada aos caminhos dos certificados e configurações específicas da instância EC2. Tentar executar este compose em outro ambiente sem ajustar esses caminhos provavelmente resultará em erros. Existem diversos tutoriais na internet que detalham os passos para configurar o HTTPS.

## 📜 Script de Deploy

### Como rodar o script de deploy

O script de deploy (`.github/scripts/deploy.sh`) é projetado para ser executado pelo pipeline do GitHub Actions.

Para executá-lo localmente (não recomendado), seria necessário configurar as seguintes variáveis de ambiente, que no pipeline são injetadas a partir dos GitHub Secrets:

*   `AWS_KEY`: A chave privada SSH para acessar a instância EC2.
*   `AWS_USER`: O usuário da instância EC2 (ex: `ubuntu`).
*   `AWS_HOST`: O endereço de IP ou DNS da instância EC2.

Com essas variáveis configuradas, o script poderia ser executado da seguinte forma:

```bash
chmod +x .github/scripts/deploy.sh
./.github/scripts/deploy.sh
```

## 🌐 Estrutura do Projeto

```
teste-tecnico-alpes/
├── app/                # Lógica da aplicação
│   ├── Http/
│   │   └── Controllers/ # Controladores da API
│   └── Models/          # Modelos do Eloquent
├── database/           # Migrations e Seeders
├── tests/              # Testes automatizados
└── routes/             # Definição das rotas da API
```

## Endpoints da API

A coleção do Postman `Vehicle API.postman_collection.json` na raiz do projeto contém todas as rotas da API e exemplos de requisições.

[Clique aqui para baixar](./Vehicle%20API.postman_collection.json)

---

<div align="center">

⭐️ Feito com 💙 por [Wescley Silva](https://github.com/WescleySil) ⭐️

</div>
