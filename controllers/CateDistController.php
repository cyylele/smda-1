<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

//引入 PHPExcel
require dirname(dirname(__FILE__)).'/include/phpexcel/PHPExcel.php';
//引入model
include('model/CateSalePerc.php');
include('model/NameTypeData.php');
//引入utils
include_once('utils/FileUtils.php');

class CateDistController extends Controller
{
  public function actionDo($type='', $year=2012, $month=1, $category=1)
  {
      function read12Sales($year, $category) {
          $currentSheet = \FileUtils::getExcelSheet('data/history.xlsx', 4);
          $currentColumn = ($year - 2012) * 12 * 3 + 1;
          for($month = 1; $month <=12; $month++)
          {
              $datas[$month -1] = $currentSheet->getCellByColumnAndRow($currentColumn,$category+2)->getValue();
              $currentColumn+=3;
          }
          return $datas;
      }

      function read12Temperatures($year)
      {
          $currentSheet = \FileUtils::getExcelSheet('data/history.xlsx', 1);
          for($month = 1;$month<=12; $month++)
          {
              $datas[$month-1] = $currentSheet->getCellByColumnAndRow(($year - 2012) * 2 + 1, $month + 2)->getValue();
          }
          return $datas;
      }

      function readCateRank($year, $month)
      {
          $currentSheet = \FileUtils::getExcelSheet('data/history.xlsx', 4);

          for($currentRow = 3; $currentRow <=11; $currentRow++)
          {
              $currentColumn = ($year - 2012) * 12 * 3  + ($month-1) * 3 + 1;
              $model = new \CateSalePerc();
              $model->setSaleAmount($currentSheet->getCellByColumnAndRow($currentColumn++,$currentRow)->getValue()/10000000);
              $model->setPercentage($currentSheet->getCellByColumnAndRow($currentColumn++,$currentRow)->getValue());
              $model->setCategory($currentSheet->getCellByColumnAndRow($currentColumn,$currentRow)->getValue());
              $models[$currentRow - 3] = $model;
          }
          return $models;
      }

      function readCateName($category)
      {
        $currentSheet = \FileUtils::getExcelSheet('data/history.xlsx', 4);
        return $currentSheet->getCellByColumnAndRow(0,$category + 2)->getValue();
      }

      // Yii::$app->response->format=Response::FORMAT_JSON;
      header("Access-Control-Allow-Origin: *");//同源策略 跨域请求 头设置
      header('content-type:text/html;charset=utf8 ');
      //获取回调函数名
      $jsoncallback = htmlspecialchars($_REQUEST['callback']);//把预定义的字符转换为 HTML 实体。

      switch($type){
        case 'cate_sales':
            //return read12Sales($year, $category);
            $models = array();
            for($category=1; $category <= 9; $category++)
            {
              $model = new \NameTypeData();
              $model->setData(read12Sales($year, $category));
              $model->setType("bar");
              $model->setName(readCateName($category));
              $models[$category -1] = $model;
            }
            $model = new \NameTypeData();
            $model->setData(read12Temperatures($year));
            $model->setType("line");
            $model->setName("平均气温");
            $model->setYAxisIndex(1);
            $models[9] = $model;
            echo $jsoncallback . "(" . json_encode($models) . ")";
            break;
        case 'temperature':
            //return read12Temperatures($year);
            echo $jsoncallback . "(" . json_encode(read12Temperatures($year)) . ")";
            break;
        case 'ranking':
            $models = readCateRank($year, $month);
            usort($models, array("CateSalePerc", "cmp"));
            //return $models;
            echo $jsoncallback . "(" . json_encode($models) . ")";
            break;
      }
  }
}
