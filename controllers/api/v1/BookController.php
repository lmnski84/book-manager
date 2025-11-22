<?php

namespace app\controllers\api\v1;

use app\components\jwt\JwtHttpBearerAuth;
use app\controllers\BaseApiController;
use app\models\Book;
use Yii;

class BookController extends BaseApiController
{
    public $modelClass = Book::class;

    /**
     * @inheritdoc
     */
    public function actions(): array
    {
        $defaultActions = parent::actions();
        unset($defaultActions['create']);
        return $defaultActions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => JwtHttpBearerAuth::class,
            'except' => ['index', 'view']
        ];

        return $behaviors;
    }

    public function actionCreate()
    {
        $userId = Yii::$app->user->getId();
        $data = Yii::$app->request->post();

        $model = new Book();
        $model->title = $data['title'];
        $model->user_id = $userId;

        if ($model->validate()) {
            $model->save();
            $model->refresh();
        }

        return $model;
    }
}