# Oficina — Sistema de Gestão

Sistema web para gestão de oficina mecânica, desenvolvido com Laravel 10. Possui área administrativa com controle de banners, serviços, contas a pagar e usuários.

## Funcionalidades

- **Site público** — página inicial com banners e serviços cadastrados
- **Contas a pagar** — suporte a contas fixas (recorrentes) e avulsas, com controle de ocorrências, alertas de vencimento e upload de comprovante
- **Banners** — gerenciamento de banners exibidos no site
- **Serviços** — cadastro de serviços oferecidos pela oficina
- **Configurações** — dados gerais do site (chave/valor)
- **Usuários** — gerenciamento de usuários com perfil `admin` e `user`

## Requisitos

- PHP 8.1+
- Composer
- MySQL
- Node.js + NPM

## Instalação

```bash
git clone <repositorio>
cd oficina

composer install
npm install && npm run build

cp .env.example .env
php artisan key:generate
```

Configure o `.env` com os dados do banco e demais variáveis, então:

```bash
php artisan migrate
php artisan storage:link
```

## Variáveis de ambiente principais

| Variável | Descrição |
|---|---|
| `APP_URL` | URL da aplicação |
| `DB_DATABASE` | Nome do banco de dados |
| `DB_USERNAME` | Usuário do banco |
| `DB_PASSWORD` | Senha do banco |

## Rotas principais

| Método | Rota | Descrição |
|---|---|---|
| GET | `/` | Site público |
| GET | `/admin/login` | Login |
| GET | `/admin` | Dashboard |
| GET | `/admin/bills` | Contas a pagar |
| GET | `/admin/services` | Serviços |
| GET | `/admin/banners` | Banners |
| GET | `/admin/settings` | Configurações |
| GET | `/admin/users` | Usuários (somente admin) |

## Deploy

O deploy é feito automaticamente via GitHub Actions ao fazer push na branch `main`. Veja [`.github/workflows/deploy.yml`](.github/workflows/deploy.yml).

Secrets necessários no repositório:

| Secret | Descrição |
|---|---|
| `SSH_HOST` | IP ou domínio do servidor |
| `SSH_USER` | Usuário SSH |
| `SSH_PRIVATE_KEY` | Chave privada SSH |
| `SSH_PORT` | Porta SSH |

## Stack

- [Laravel 10](https://laravel.com)
- [Laravel Sanctum](https://laravel.com/docs/sanctum)
- [Vite](https://vitejs.dev)
