<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

//引入 PHPExcel
require dirname(dirname(__FILE__)).'/include/phpexcel/PHPExcel.php';
//引入model
include('model/CateDateProp.php');

class CateTrendController extends Controller
{
  public function actionDo($type='', $year=2012, $month=0)
  {
      function readCateProp($year, $month)
      {
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
            $currentSheet = $PHPExcel->getSheet(3);

            //取得最大的行号
            $allRow = $currentSheet->getHighestRow();
            for($currentRow = 2 ;$currentRow <= $allRow; $currentRow++)
            {
                $currentColumn = ($year - 2012) * 12 + $month + 1;
                $model = new \CateDateProp();
                $val = $currentSheet->getCellByColumnAndRow(0,$currentRow)->getValue();
                $model->setCategory($val);

                $val = $currentSheet->getCellByColumnAndRow($currentColumn,$currentRow)->getValue();
                $model->setCategoryProportion($val);

                $months = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
                $model->setDate($months[$month-1] ." ". $year);

                $models[($currentRow-2)*9 + $month -1] = $model;
            }
            return $models;
      }

      function readDetailedCateProportion ($year)
      {
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
        $currentSheet = $PHPExcel->getSheet(3);

        //取得最大的行号
        $allRow = $currentSheet->getHighestRow();
        for($currentRow = 2 ;$currentRow <= $allRow; $currentRow++)
        {
            $currentColumn = ($year - 2012) * 12 + 1;
            for($month = 1; $month <=12; $month++)
            {
                $model = new \CateDateProp();
                $val = $currentSheet->getCellByColumnAndRow(0,$currentRow)->getValue();
                $model->setCategory($val);

                $val = $currentSheet->getCellByColumnAndRow($currentColumn,$currentRow)->getValue();
                $model->setCategoryProportion($val);

                $months = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
                $model->setDate($months[$month-1] ." ". $year);

                $models[($currentRow-2)*9 + $month -1] = $model;
                $currentColumn++;
            }
        }
        return $models;
      }

      // Yii::$app->response->format=Response::FORMAT_JSON;

      header("Access-Control-Allow-Origin: *");//同源策略 跨域请求 头设置
      header('content-type:text/html;charset=utf8 ');
      //获取回调函数名
      $jsoncallback = htmlspecialchars($_REQUEST['callback']);//把预定义的字符转换为 HTML 实体。

      switch($type){
        case 'category_proportion':
            // return readCateProp($year, $month);
            echo $jsoncallback . "(" . json_encode(readCateProp($year, $month)) . ")";
            break;
        case 'detailed_cate_Proportion':
            //return readDetailedCateProportion($year);
            echo $jsoncallback . "(" . json_encode(readDetailedCateProportion($year)) . ")";
            break;
      }
  }
}
