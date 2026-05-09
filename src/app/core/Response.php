<?php

class Response
{
    public static function json($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public static function success($data = [])
    {
        self::json(['status' => 'sucesso', ...$data], 200);
    }

    public static function created($data = [])
    {
        self::json(['status' => 'criado', ...$data], 201);
    }

    public static function error($data = [])
    {
        self::json(['erro' => 'Requisição inválida', ...$data], 400);
    }

    public static function unauthorized($data = [])
    {
        self::json(['erro' => 'Acesso não autorizado', ...$data], 401);
    }

    public static function forbidden($data = [])
    {
        self::json(['erro' => 'Acesso negado', ...$data], 403);
    }

    public static function notFound($data = [])
    {
        self::json(['erro' => 'Não encontrado', ...$data], 404);
    }

    public static function internalError($data = [])
    {
        self::json(['erro' => 'Erro interno', ...$data], 500);
    }
}