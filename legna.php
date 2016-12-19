<?php
  echo $_SERVER["REQUEST_URI"];
  $arr = array('mmm' => 1, 'nnn' => '2');
  echo json_encode($arr);
?>
