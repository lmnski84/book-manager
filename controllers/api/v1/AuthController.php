<?php

namespace app\controllers\api\v1;

use app\services\AuthService;
use yii\rest\Controller;
use app\models\Login;

class AuthController extends Controller
{

    public function actionLogin()
    {
        $authService = new AuthService();

        $model = new Login();
        $model->load(\Yii::$app->request->bodyParams, '');

        $model->validate();
        $authService->login($model);
        return $model;
    }

    public function actionValidation($token)
    {

        $authService = new AuthService();
        return $authService->validationKey($token);
    }
}