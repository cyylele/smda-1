<?php
/**
 * Created by PhpStorm.
 * User: belinda
 * Date: 2016/12/21
 * Time: 15:51
 */
$response['status']=200;
$response['msg']="success";
echo "login(".json_encode($response).")";//login({"status":200,"msg":"success"})
