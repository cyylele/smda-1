<?php
/**
 * Created by PhpStorm.
 * User: belinda
 * Date: 2016/12/20
 * Time: 21:56
 */

include_once('utils/CateUtils.php');
class CateRank
{
    var $category;
    var $sale_amount;
    var $weather;

    function setCategory ($category) {
        $this->category =\CateUtils::convertCateToNum($category) ;
    }
    function sale_amount ($sale_amount) {
        $this->sale_amount =number_format($sale_amount,2,'.','');
    }
    function setWeather ($weather) {
        $this->weather =$weather ;
    }

}
