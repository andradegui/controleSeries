# Controle de Séries

- PHP 8.2;
- Symfony 6.3;
- Boostrap 5.2;
- Mysql;
- SQLite p/ testes.

## Comandos Úteis

### Subir servidor
`php -S localhost:8080 -t public`

### Ver comandos do Symfony
`php bin/console`

### Criar Migration
`php bin/console`

### Criar Entity
`php bin/console make:entity Series`

### Criar Controller
`php bin/console make:controller SeriesController`

### Criar Banco de dados (SQLite)
`php bin/console doctrine:database:create`

### Criar Migration
`php bin/console make:migration`

### Executar Migration
`php bin/console doctrine:migrations:migrate`

### Reverter Migration
`php bin/console doctrine:migrations:execute --down 'DoctrineMigrations\Version20240308140841'`

### Listar as rotas da aplicação
`php bin/console debug:router`

### Rodar SQL pelo terminal
`php bin/console doctrine:query:sql`

### Criar arquivo de formulário
`php bin/console make:form SeriesType`

### Criar funcionalidade de autenticação
> Documentação Symfony p/ auxiliar 
> https://symfony.com/doc/6.3/security.html#form-login

`php bin/console make:user`
`php bin/console make:migration`
`composer require symfonycasts/verify-email-bundle`
`php bin/console make:registration-form`

### Testes 

`php bin/phpunit`
`composer require --dev dama/doctrine-test-bundle`
`composer require --dev orm-fixtures`

> No .env.test deve ser criado um novo BD chamado test
`DATABASE_URL="sqlite:///%kernel.project_dir%/var/test.db"`
`MAILER_DSN=null://null`
`MESSENGER_TRANSPORT_DSN=doctrine://default?auto_setup=0`
`php bin/console --env=test doctrine:schema:create`

`php bin/console --env=test doctrine:fixtures:load`
