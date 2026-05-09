<?php

require_once __DIR__ . '/require.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    PagesController::register();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<main class="container">
    <h1>Cadastro</h1>
    <form method="POST">
        <label for="name">Nome:</label>
        <input type="text" name="name" id="name" placeholder="Digite seu nome">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="seu@email.com" required>

        <label for="phone">Número</label>
        <input type="tel" name="phone" id="phone" placeholder="(51) 99999-9999">

        <label for="bio">Biografia</label>
        <textarea name="bio" id="bio" placeholder="Fale sobre você..." rows="4"></textarea>

        <label for="password">Senha</label>
        <div class="input-box">
            <input type="password" name="password" id="password" placeholder="Digite sua senha" required>
            <span id="toggle">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                    <circle cx="12" cy="12" r="3" />
                </svg>
            </span>

        </div>

        <button type="submit">Criar Conta</button>
        <a href="/login">Já tem uma conta? Entrar</a>
    </form>
</main>

<script src="/js/index.js" type="module"></script>