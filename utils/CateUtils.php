<?php
/**
 * Created by PhpStorm.
 * User: belinda
 * Date: 2016/12/20
 * Time: 20:59
 */
class CateUtils
{
    //static $cates = array(1,2,3,4,5,6,7,8,9);

    static function convertCateToNum($cate)
    {
        switch($cate){
            case  1:     return '洗发沐浴';
            case  2:     return '卫生巾/护垫/成人尿裤';
            case  3:     return '家私/皮具护理品';
            case  4:     return '香熏用品';
            case  5:     return '纸品/湿巾';
            case  6 :    return '家庭环境清洁剂';
            case  7:     return '驱虫用品';
            case  8:     return '衣物清洁剂/护理剂';
            case  9:     return '室内除臭/芳香用品';

        }
    }
}