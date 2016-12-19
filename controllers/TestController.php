<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class TestController extends Controller
{
  public function actionSay($msg = 'Hello')
  {
      Yii::$app->response->format=Response::FORMAT_JSON;


      return ['code'=>false,'message'=>$msg];
  }
}
