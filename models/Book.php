<?php

namespace app\models;

use yii\db\ActiveRecord;

class Book extends ActiveRecord
{

    public function fields()
    {
        $fields = parent::fields();
        return [
            'id' => $fields['id'],
            'title' => $fields['title'],
        ];
    }

    public function extraFields()
    {
        return [
            'user' => function ($model) {
                return $this->user->login;
            }
        ];
    }

    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['title'], 'trim'],
            [['title'], 'string', 'min' => 3, 'max' => 255],
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}