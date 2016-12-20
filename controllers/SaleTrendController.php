<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

//引入 PHPExcel
require dirname(dirname(__FILE__)).'/include/phpexcel/PHPExcel.php';
//引入model
include('model/MonthSalePercTemp.php');

class SaleTrendController extends Controller
{
  public function actionDo($type='', $year=2012)
  {
      function readMonthSalePercTemp($year){

        $file = 'data/history.xlsx';
        $objPHPExcel = new \PHPExcel();
        $PHPReader = new \PHPExcel_Reader_Excel2007();
        if(!$PHPReader->canRead($file))
        {
            $PHPReader = new PHPExcel_Reader_Excel5();
            if(!$PHPReader->canRead($file))
            {
                echo 'Excel not found';
                return ;
            }
        }
        $PHPExcel = $PHPReader->load($file);
        $currentSheet = $PHPExcel->getSheet(2);

        $currentRow = ($year - 2012) * 12 + 2;
        for($count = 1 ;$count <= 12; $count++)
        {
            $model = new \MonthSalePercTemp();
            //获取该年该月温度
            $temp = readTemperature($year, $count);
            $model->setTemperature($temp);
            $model->setMonth($count ."月");

            $val = $currentSheet->getCellByColumnAndRow(1,$currentRow)->getValue();
            $model->setMonthSales($val);

            $val = $currentSheet->getCellByColumnAndRow(7,$currentRow)->getValue();
            $model->setMonthPercentage($val);

            $models[$count-1] = $model;
            $currentRow++;
        }
        return $models;
      }

      function readTemperature($year, $month){
        $file = 'data/history.xlsx';
        $objPHPExcel = new \PHPExcel();
        $PHPReader = new \PHPExcel_Reader_Excel2007();
        if(!$PHPReader->canRead($file))
        {
            $PHPReader = new PHPExcel_Reader_Excel5();
            if(!$PHPReader->canRead($file))
            {
                echo 'Excel not found';
                return ;
            }
        }
        $PHPExcel = $PHPReader->load($file);
        $currentSheet = $PHPExcel->getSheet(1);
        $val = $currentSheet->getCellByColumnAndRow(($year - 2012) * 2 + 1, $month + 2)->getValue();
        return $val;
      }

      //Yii::$app->response->format=Response::FORMAT_JSON;

      header("Access-Control-Allow-Origin: *");//同源策略 跨域请求 头设置
      header('content-type:text/html;charset=utf8 ');
      //获取回调函数名
      $jsoncallback = htmlspecialchars($_REQUEST['callback']);//把预定义的字符转换为 HTML 实体。

      switch($type){
        case 'month_sales':
            // return readMonthSalePercTemp($year);
            echo $jsoncallback . "(" . json_encode(readMonthSalePercTemp($year)) . ")";
            break;
      }
  }
}
