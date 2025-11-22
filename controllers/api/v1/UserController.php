<?php

namespace app\controllers\api\v1;

use app\components\jwt\JwtHttpBearerAuth;
use app\controllers\BaseApiController;
use app\models\User;

class UserController extends BaseApiController
{
    public $modelClass = User::class;

    public function actions()
    {
        $actions = parent::actions();
        unset(
            $actions['index'],
            $actions['update'],
            $actions['delete'],
        );
        return $actions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => JwtHttpBearerAuth::class,
            'except' => ['create']
        ];
        return $behaviors;
    }

}