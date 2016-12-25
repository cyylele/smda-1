<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

//引入 PHPExcel
require dirname(dirname(__FILE__)).'/include/phpexcel/PHPExcel.php';
//引入model
include('model/BrandSalePercTemp.php');
include('model/SymbolDateAmount.php');
//引入utils
include_once('utils/DateUtils.php');
include_once('utils/FileUtils.php');

class BrandDistController extends Controller
{
  public function actionDo($type='', $year=2012, $month=4)
  {
      function readBrandSalePercTemp($year, $month){
        //获取该年该月温度
        $temp = readTemperature($year, $month);

        //根据年月计算是第几大列
        $no = ($year - 2012) * 12 + ($month - 3) + 1;
        $currentSheet = \FileUtils::getExcelSheet('data/history.xlsx', 5);
        $allRow = $currentSheet->getHighestRow();//取得最大行号
        for($currentRow = 3 ;$currentRow <= $allRow; $currentRow++)
        {
            $model = new \BrandSalePercTemp();
            $model->setTemperature($temp);

            $currentColumn = ($no-1) * 3;
            $val = $currentSheet->getCellByColumnAndRow($currentColumn, $currentRow)->getValue();
            $model->setBrand($val);

            $currentColumn++;
            $val = $currentSheet->getCellByColumnAndRow($currentColumn, $currentRow)->getValue();
            $model->setSaleAmount($val);

            $currentColumn++;
            $val = $currentSheet->getCellByColumnAndRow($currentColumn, $currentRow)->getValue();
            $model->setPercentage($val);

            $models[$currentRow-3] = $model;
        }
        return $models;
      }

      function readTemperature($year, $month)
      {
        $currentSheet = \FileUtils::getExcelSheet('data/history.xlsx', 1);
        $val = $currentSheet->getCellByColumnAndRow(($year - 2012) * 2 + 1, $month + 2)->getValue();
        return $val;
      }

      function readSymbolDateAmount($year, $month, $str)
      {
        //根据年月计算是第几大列
        $no = ($year - 2012) * 12 + ($month) - 3;
        $currentSheet = \FileUtils::getExcelSheet('data/history.xlsx', 5);
        $allRow = $currentSheet->getHighestRow();//取得最大的行号
        for($currentRow = 3 ;$currentRow <= $allRow; $currentRow++)
        {
              $currentColumn = $no * 3;
              $model = new \SymbolDateAmount();
              $val = $currentSheet->getCellByColumnAndRow($currentColumn,$currentRow)->getValue();
              $model->setSymbol($val);

              $currentColumn++;
              $val = $currentSheet->getCellByColumnAndRow($currentColumn,$currentRow)->getValue();
              $model->setAmount($val);

              $model->setDate($str);
              $models[$currentRow-3] = $model;
        }
        return $models;
      }

      function getHighestModels($models)
      {
        $count = count($models);
        for($index = 0; $index < $count; $index++)
        {
          $model = $models[$index];
          @$allAmounts[$model->symbol] += $model->amount;
        }
        arsort($allAmounts);
        $index = 0;
        foreach($allAmounts as $x=>$x_value)
        {
            $allSymbols[$index++] = $x;
        }
        $top4Symbols = array_slice($allSymbols,0,4);
        // var_dump($top4Symbols);

        $newModels = array();
        $index = 0;
        foreach($models as $x=>$x_value)
        {
          // echo $x_value->symbol;
          if(in_array($x_value->symbol, $top4Symbols))
          {
            $newModels[$index++] = $x_value;
          }

        }
        return $newModels;
      }

      //Yii::$app->response->format=Response::FORMAT_JSON;
      header("Access-Control-Allow-Origin: *");//同源策略 跨域请求 头设置
      header('content-type:text/html;charset=utf8 ');
      //获取回调函数名
      $jsoncallback = htmlspecialchars($_REQUEST['callback']);//把预定义的字符转换为 HTML 实体。

      switch($type){
        case 'sale_amount':
            $models = readBrandSalePercTemp($year,$month);
            usort($models, array("BrandSalePercTemp", "cmp"));
            //return array_slice($models,0,12);
            echo $jsoncallback . "(" . json_encode(array_slice($models,0,12)) . ")";
            break;
        case 'market_shares':
            $models = array();
            $months = \DateUtils::$months;
            if($year == 2012)
            {
                for($curMonth = 3; $curMonth <= 12; $curMonth++)
                {
                    $subModels = readSymbolDateAmount($year, $curMonth, $months[$curMonth-1] . " " . $year);
                    $models = array_merge($models, $subModels);
                }
            }
            else if($year == 2016)
            {
                for($curMonth = 1; $curMonth <= 11; $curMonth++)
                {
                    $subModels = readSymbolDateAmount($year, $curMonth, $months[$curMonth-1] . " " . $year);
                    $models = array_merge($models, $subModels);
                }
            }
            else
            {
                for($curMonth = 1; $curMonth <= 12; $curMonth++)
                {
                    $subModels = readSymbolDateAmount($year, $curMonth, $months[$curMonth-1] . " " . $year);
                    $models = array_merge($models, $subModels);
                }
            }
            usort($models, array("SymbolDateAmount", "cmp"));
            $models = getHighestModels($models);
            //return $models;
            echo $jsoncallback . "(" . json_encode($models) . ")";
            break;
      }
  }
}
