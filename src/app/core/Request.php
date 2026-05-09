<?php

class Request
{
    public static function body()
    {
        return json_decode(file_get_contents('php://input'), true) ?? [];
    }

    public static function input($key)
    {
        return self::body()[$key] ?? null;
    }

    public static function query($key = null)
    {
        if ($key) {
            return $_GET[$key] ?? null;
        }
        return $_GET;
    }

    public static function header($key)
    {
        $key = 'HTTP_' . strtoupper(str_replace('-', '_', $key));
        return $_SERVER[$key] ?? null;
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function path()
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
}