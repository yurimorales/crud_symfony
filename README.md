# CRUD Symfony

Projeto que tem por base ser um CRUD básico utilizando os recursos do framework Symfony.  
Versão Symfony: 5.1.7  
Versão do PHP: 7.4  
Versão MySQL: 5.7  

## Como rodar o projeto com Docker

### 1. Clone o repositório

```bash
git clone https://github.com/yurimorales/crud_symfony.git
cd crud_symfony
```

### 2. Suba os containers

```bash
docker-compose up --build
```

A aplicação estará disponível em [http://localhost:8000](http://localhost:8000).

### 3. Instale as dependências (opcional, caso queira rodar comandos manualmente)

Se precisar rodar comandos do Symfony ou Composer dentro do container, utilize:

```bash
docker-compose exec app bash

# Dentro do container:
composer install
composer dump-autoload
php bin/console doctrine:migrations:migrate
```

### 4. Configuração do banco de dados

O arquivo `.env` já está configurado para conectar ao banco MySQL do container:

```
DATABASE_URL=mysql://db_user:db_password@db:3306/db_name?serverVersion=5.7
```

Se necessário, ajuste conforme sua necessidade.
