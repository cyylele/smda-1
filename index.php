<?php
  echo $_SERVER["REQUEST_URI"];
  $arr = array('aaa' => 1, 'bbb' => '2');
  echo json_encode($arr);
?>
