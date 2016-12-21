<?php
class NameTypeData
{
  var $name;
  var $type;
  var $data;
  var $yAxisIndex;

  function setName ($name) {
      $this->name = $name;
  }
  function setType ($type) {
      $this->type = $type;
  }
  function setData ($data) {
      $this->data = $data;
  }
  function setYAxisIndex($yAxisIndex) {
      $this->yAxisIndex = $yAxisIndex;
  }
}
