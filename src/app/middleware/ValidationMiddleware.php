<?php

class ValidationMiddleware
{
    public static function required($data, $fields)
    {
        foreach ($fields as $field) {
            if (empty($data[$field])) {
                $response = new Response();
                $response->json(['erro' => "Campo {$field} obrigatório"], 422);
            }
        }
    }
}