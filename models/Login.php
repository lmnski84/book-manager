<?php

namespace app\models;

use yii\base\Model;

class Login extends Model
{
    public string $login = '';
    public string $password = '';
    public string $token;

    public function fields()
    {
        $fields = parent::fields();
        return [
            'login' => $fields['login'],
            'token' => $fields['token'],
        ];
    }

    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            [['login', 'password'], 'trim'],
        ];
    }

}