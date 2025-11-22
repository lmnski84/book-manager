<?php

namespace app\services;

use app\models\Login;
use app\models\User;
use Yii;

class AuthService
{
    private ?User $user;
    private Login $loginModel;

    public function login(Login $loginModel): void
    {
        $this->loginModel = $loginModel;
        if ($this->_authentication($loginModel->login, $loginModel->password)) {
            $data = $this->user->toArray(['id', 'login']);
            $loginModel->token = Yii::$app->jwt->generateJWT($data);
        }
    }

    private function _authentication(string $login, string $password): bool
    {
        $this->user = User::findOne(['login' => $login]);
        if (!$this->user) {
            $this->loginModel->addError('login', 'User not found');
            return false;
        }
        if (!Yii::$app->security->validatePassword($password, $this->user->password)) {
            $this->loginModel->addError('password', 'Incorrect password');
            return false;
        }
        return true;
    }

    public function validationKey($token)
    {
        $msg = Yii::$app->jwt->getPayload($token);
        return $msg;
    }

}