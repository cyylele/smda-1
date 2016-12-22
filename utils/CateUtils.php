<?php
/**
 * Created by PhpStorm.
 * User: belinda
 * Date: 2016/12/20
 * Time: 20:59
 */
class CateUtils
{
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
    static function convertCityToNum($city){
        switch ($city){
            case '哈尔滨';return 0;
            case '长春';return 2;
            case '沈阳';return 4;
            case '北京';return 6;
            case '天津';return 8;
            case '呼和浩特';return 10;
            case '石家庄';return 12;
            case '太原';return 14;
            case '济南';return 16;
            case '乌鲁木齐';return 18;
            case '西宁';return 20;
            case '兰州';return 22;
            case '西安';return 24;
            case '郑州';return 26;
            case '合肥';return 28;
            case '南京';return 30;
            case '上海';return 32;
            case '杭州';return 34;
            case '拉萨';return 36;
            case '成都';return 38;
            case '重庆';return 40;
            case '长沙';return 42;
            case '武汉';return 44;
            case '南昌';return 46;
            case '福州';return 48;
            case '贵阳';return 50;
            case '昆明';return 52;
            case '南宁';return 54;
            case '广州';return 56;
            case '海口';return 58;
        }
    }


}
