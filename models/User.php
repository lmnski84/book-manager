<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $login
 * @property string $password
 * @property string $email
 */
class User extends ActiveRecord implements IdentityInterface
{

    public function rules()
    {
        return [
            [['login', 'password', 'email'], 'required'],
            [['login', 'password', 'email'], 'trim'],
            [['login', 'email'], 'unique'],
            [['login'], 'string', 'min' => 3, 'max' => 50],
            [['password'], 'string', 'min' => 3, 'max' => 20],
            [['email'], 'email'],
        ];
    }

    public function afterValidate()
    {
        parent::afterValidate();
        $this->setPassword();
    }

    public function fields()
    {
        $fields = parent::fields();
        unset($fields['password']);
        return $fields;
    }

    public function getBooks(): ActiveQuery
    {
        return $this->hasMany(Book::class, ['user_id' => 'id']);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public static function findIdentity($id)
    {
//        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        $data = $token->data;
        $id = $data->id;
        $login = $data->login;
        if($id && $login) {
            return static::findOne(['id' => $id, 'login' => $login]);
        }
        return null;
    }

    public function setPassword()
    {
        $this->password = Yii::$app->security->generatePasswordHash($this->password);
    }



    public function getAuthKey()
    {
        //
    }

    public function validateAuthKey($authKey)
    {
        //
    }

}
