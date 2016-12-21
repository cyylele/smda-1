<?php
/**
 * Created by PhpStorm.
 * User: belinda
 * Date: 2016/12/20
 * Time: 20:07
 */
namespace app\controllers;

use yii\web\Controller;


//引入 PHPExcel
require dirname(dirname(__FILE__)).'/include/phpexcel/PHPExcel.php';
//引入model
include('model/CateRank.php');
//引入utils
include_once('utils/CateUtils.php');
include_once('utils/FileUtils.php');
class CateRankController extends Controller
{
    public function actionDo($type='',$city='上海')
    {

        function getalphnum($char){
            $array=array('A','B','C','D','E','F','G','H','I','J','L','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
            $len=strlen($char);
            $sum= 0;
            for($i=0;$i<$len;$i++){
                $index=array_search($char[$i],$array);
                $sum=$sum+($index+1)*pow(26,$len-$i-1);
            }
            return $sum;
        }
        $currentSheet = \FileUtils::getExcelSheet('data/future.xlsx', 2);
        $currentRow=\CateUtils::convertCityToNum($city);
        $lastColumn = $currentSheet->getHighestColumn();//取得最大的列
        $models=array();
        $allcolumn= getalphnum( $lastColumn);
        echo $currentRow;
        for($currentColumn = 0 ;$currentColumn < $allcolumn; $currentColumn++)
        {
            //echo "test";
            $model = new \CateRank();
            $val1 = $currentSheet->getCellByColumnAndRow($currentColumn,$currentRow-1)->getValue();
            $val = $currentSheet->getCellByColumnAndRow($currentColumn,$currentRow)->getValue();
            $model->setCategory($val1);
            $model->sale_amount($val);
            $models[$currentColumn] = $model;
        }

        header("Access-Control-Allow-Origin: *");//同源策略 跨域请求 头设置
        header('content-type:text/html;charset=utf8 ');
        //获取回调函数名
        $jsoncallback = htmlspecialchars($_REQUEST['callback']);//把预定义的字符转换为 HTML 实体。

        switch($type){
            case 'cate_rank':
                echo $jsoncallback . "(" . json_encode($models) . ")";
                break;

        }

    }
}
