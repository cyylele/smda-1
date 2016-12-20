<?php
/**
 * Created by PhpStorm.
 * User: belinda
 * Date: 2016/12/20
 * Time: 21:56
 */
//引入utils
include_once('utils/CateUtils.php');
class CateRank
{
    var $category;
    var $sale_amount;

    function setCategory ($category) {
        $this->category =\CateUtils::convertCateToNum($category) ;
    }
    function sale_amount ($sale_amount) {
        $this->sale_amount = $sale_amount;
    }

}
