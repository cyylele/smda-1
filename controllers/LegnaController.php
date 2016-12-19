<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class LegnaController extends Controller
{
    public function actionSit($msg = 'Hello2')
    {
        Yii::$app->response->format=Response::FORMAT_JSON;


        return ['code'=>false,'message'=>$msg];
    }
}