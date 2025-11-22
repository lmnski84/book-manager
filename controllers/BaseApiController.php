<?php

namespace app\controllers;


use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\ErrorAction;
use yii\web\Response;

class BaseApiController extends ActiveController
{

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'data',
    ];

    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }

}
