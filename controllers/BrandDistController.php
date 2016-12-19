<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

//引入 PHPExcel
require dirname(dirname(__FILE__)).'/include/phpexcel/PHPExcel.php';
//引入model
include('model/BrandSaleTemp.php');

class BrandDistController extends Controller
{
  public function actionDo($type='', $year=2012, $month=4)
  {
      function readHistory($year, $month){
        //获取该年该月温度
        $temp = readTemperature($year, $month);

        //根据年月计算是第几大列
        $no = ($year - 2012) * 12 + ($month - 3) + 1;

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
        $currentSheet = $PHPExcel->getSheet(5);
        //取得最大的列号
        $allColumn = $currentSheet->getHighestColumn();
        //取得最大的行号
        $allRow = $currentSheet->getHighestRow();
        for($currentRow = 3 ;$currentRow <= $allRow; $currentRow++)
        {
            $model = new \BrandSaleTemp();
            $model->setTemperature($temp);

            $currentColumn = ($no-1) * 3;
            $val = $currentSheet->getCellByColumnAndRow($currentColumn,$currentRow)->getValue();
            $model->setBrand($val);

            $currentColumn++;
            $val = $currentSheet->getCellByColumnAndRow($currentColumn,$currentRow)->getValue();
            $model->setSaleAmount($val);

            $models[$currentRow-3] = $model;
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

      Yii::$app->response->format=Response::FORMAT_JSON;

      switch($type){
        case 'sale_amount':
            $models = readHistory($year,$month);
            usort($models, array("BrandSaleTemp", "cmp"));
            return array_slice($models,0,12);
        case 'market_shares':


            echo 'market_shares';
            break;
      }
  }
}
