<?php
/**
 * Created by PhpStorm.
 * User: belinda
 * Date: 2016/12/21
 * Time: 15:51
 */
$data['id']=1;
$data['msg']="asdasdasd";
$data1['id']=2;
$data1['msg']="22222";
$response[0]=$data;
$response[1]=$data1;
echo "login(".json_encode($response).")";//login({"status":200,"msg":"success"})
