# CRUD Symfony

Projeto que tem por base, ser um CRUD básico utilizando os recursos do framework Symfony.  
Versão Symfony: 5.1.7  
Versão do PHP: 7.2  
Versão MySQL: 5.7  

## Clonando o projeto  
Depois de clonar o projeto, verificar se o composer está instalado. Caso não não estiver instalado, instalar o composer na versão mais atual.  
Logo depois do projeto ser clonado, entrar na pasta do projeto e rodar o comando: composer install  

## Configuração banco MySQL
No arquivo na raiz do projeto, encontra-se o arquivo .env, contendo a seguinte linha:  
```
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7
```
Basta realizar as mudanças necessárias, apontando para o respectivo banco desejado.  
Exemplo:  DATABASE_URLmysql://(usuario):(senha-usuario)@(ipaddress-banco):(porta)/(nome-do-banco)?serverVersion=5.7  

Segue imagem abaixo com os comando de criação do banco, e o comando para rodar o projeto locahost, utilizando o servidor embutido do PHP  

(https://drive.google.com/file/d/1EJGmRdaD7iKo6jr3FpsXfvTLHAWmELzu/view?usp=sharing)
