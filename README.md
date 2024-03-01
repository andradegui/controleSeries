# Controle de Séries

- PHP 8.2;
- Symfony 6.3;
- Boostrap 5.2;
- SQLite.

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

### Listar as rotas da aplicação
`php bin/console debug:router`
