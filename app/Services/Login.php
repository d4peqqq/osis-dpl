<?php

namespace App\Services;

class Login
{
    public function authenticate($username, $password, $database)
    {
        $user = $database->findUser($username);

        if (!$user) {
            return "User tidak ditemukan";
        }

        if ($user['password'] === $password) {
            return "Login berhasil";
        }

        return "Password salah";
    }
}