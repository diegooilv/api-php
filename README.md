# API - PHP

Projeto de estudo de uma API REST em PHP puro, sem frameworks.

## Estrutura

```
├── docker/
│   ├── apache.conf
│   └── init.sql
├── src/
│   ├── app/
│   │   ├── api/
│   │   │   └── index.php
│   │   ├── controller/
│   │   │   └── UserController.php
│   │   ├── core/
│   │   │   ├── Database.php
│   │   │   ├── Response.php
│   │   │   └── Router.php
│   │   ├── middleware/
│   │   │   ├── AuthMiddleware.php
│   │   │   └── ValidationMiddleware.php
│   │   ├── model/
│   │   │   ├── TokenModel.php
│   │   │   └── UserModel.php
│   │   └── pages/
│   │       ├── 404.php
│   │       └── index.php
│   ├── config/
│   │   └── database.php
│   └── public/
│       └── index.php
├── docker-compose.yml
├── Dockerfile
├── .env
├── .gitattributes
├── .gitignore
├── LICENSE
└── README.md
```

## Rotas

Base: `http://localhost:8080/api`

| Método | Rota | Descrição | Auth |
|--------|------|-----------|------|
| POST | `/user/register` | Cadastrar usuário | - |
| POST | `/user/login` | Login — retorna token | - |
| POST | `/user/logout` | Logout — invalida token | `Bearer` (dono) |
| GET | `/user/index` | Listar todos os usuários | `Bearer` (admin) |
| GET | `/user/{id}` | Buscar usuário por ID | `Bearer` (dono ou admin) |
| PATCH | `/user/update/{id}` | Atualização parcial | `Bearer` (dono) |
| PUT | `/user/update/{id}` | Atualização completa | `Bearer` (dono) |
| DELETE | `/user/delete` | Excluir conta autenticada | `Bearer` (dono) |

## Autenticação

As rotas protegidas exigem o token no header:

```
Authorization: Bearer seu_token_aqui
```

## Executando

```bash
docker compose up --build
```

Resetar banco:

```bash
docker compose down -v
docker compose up --build
```

## Credenciais de teste

Admin:

```json
{
  "email": "diego@email.com",
  "password": "password"
}
```

Usuário:

```json
{
  "email": "edu@email.com",
  "password": "password"
}
```

---
Atualizado em: 04/05/2026
