<?php

// name, email, password, phone, bio
class UserController
{
    public function register()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);
            ValidationMiddleware::required($body, ['name', 'email', 'password']);

            $userModel = new UserModel();
            $exists = $userModel->findByEmail($body['email']);

            if ($exists) {
                Response::error(['erro' => 'Email já cadastrado']);
            }

            $user = $userModel->create($body);
            Response::created(['user' => $user]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            Response::internalError();
        }
    }

    public function index()
    {
        try {
            $row = AuthMiddleware::admin();
            if (!$row) {
                Response::forbidden();
            }

            $userModel = new UserModel();
            $users = $userModel->index();
            foreach ($users as &$user) {
                unset($user['password']);
            }
            Response::success(['users' => $users]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            Response::internalError();
        }
    }

    public function show($id)
    {
        try {
            $userModel = new UserModel();
            $user = $userModel->findById($id);
            if (!$user) {
                Response::notFound(['erro' => 'Usuário não encontrado']);
            }

            $userRequest = AuthMiddleware::handle();
            $userRequest = $userModel->findById($userRequest['user_id']) ?? null;

            $isOwner = $user['id'] == ($userRequest['id'] ?? null);
            $isAdmin = ($userRequest['role'] ?? null) === 'admin';

            if (!$isOwner && !$isAdmin) {
                Response::forbidden();
            }

            unset($user['password']);
            Response::success(['user' => $user]);

        } catch (Exception $e) {
            error_log($e->getMessage());
            Response::internalError();
        }
    }

    public function patch($id)
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);

            $row = AuthMiddleware::handle();
            if ($row['user_id'] != $id) {
                Response::forbidden(['erro' => 'Você não é esse usuário!']);
            }

            $userModel = new UserModel();
            $status = $userModel->update($id, $body);
            if ($status) {
                Response::success();
            } else {
                Response::notFound(['erro' => 'ID Inválido!']);
            }

        } catch (Exception $e) {
            error_log($e->getMessage());
            Response::internalError();
        }
    }

    public function update($id)
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);

            $row = AuthMiddleware::handle();
            if ($row['user_id'] != $id) {
                Response::forbidden(['erro' => 'Você não é esse usuário!']);
            }

            ValidationMiddleware::required($body, ['name', 'phone', 'bio']);

            $userModel = new UserModel();
            $status = $userModel->update($id, $body);
            if ($status) {
                Response::success();
            } else {
                Response::notFound(['erro' => 'ID Inválido!']);
            }

        } catch (Exception $e) {
            error_log($e->getMessage());
            Response::internalError();
        }
    }

    public function login()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);

            ValidationMiddleware::required($body, ['email', 'password']);
            $userModel = new UserModel();
            $user = $userModel->findByEmail($body['email']);
            if (!$user) {
                Response::notFound(['erro' => 'Email Inválido!']);
            }

            if (!password_verify($body['password'], $user['password'])) {
                Response::unauthorized();
            }

            $tokenModel = new TokenModel();
            $token = $tokenModel->create($user['id']);
            Response::success(['token' => $token]);

        } catch (Exception $e) {
            error_log($e->getMessage());
            Response::internalError();
        }
    }

    public function logout()
    {
        try {
            $row = AuthMiddleware::handle();
            $tokenModel = new TokenModel();
            $tokenModel->deleteByToken($row['token']);
            Response::success();

        } catch (Exception $e) {
            error_log($e->getMessage());
            Response::internalError();
        }
    }

    public function delete()
    {
        try {
            $row = AuthMiddleware::handle();
            $userModel = new UserModel();
            $userModel->delete($row['user_id']);
            Response::success();
        } catch (Exception $e) {
            error_log($e->getMessage());
            Response::internalError();
        }
    }
}