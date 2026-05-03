<?php

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

if (str_ends_with($uri, '.php')) {
    $uri = substr($uri, 0, -4);
}

// api

if (str_starts_with($uri, 'api')) {
    require __DIR__ . '/../app/api/index.php';
    exit;
}

// pages

if ($uri === '') {
    $uri = 'index';
}

$file = __DIR__ . '/../app/pages/' . $uri . '.php';

header('Content-Type: text/html; charset=utf-8');
header('Content-Language: pt-BR');

if (file_exists($file)) {
    require $file;
} else {
    require __DIR__ . '/../app/pages/404.php';
}