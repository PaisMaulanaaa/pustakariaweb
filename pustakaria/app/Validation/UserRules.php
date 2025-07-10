<?php

namespace App\Validation;

use App\Models\UserModel;

class UserRules
{
    public function verify_user_password(string $str, string $fields, array $data): bool
    {
        if (empty($str)) {
            return true;
        }

        $userId = $fields;
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        return password_verify($str, $user['password']);
    }
} 