<?php

class Response
{
    public function json($data, $status = 500)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}