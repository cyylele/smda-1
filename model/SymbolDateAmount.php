<?php
include_once('utils/DateUtils.php');

class SymbolDateAmount
{
  var $symbol;
  var $date;
  var $price;

  function setSymbol ($symbol) {
      $this->symbol = $symbol;
  }
  function setDate ($date) {
      $this->date = $date;
  }
  function setAmount ($price) {
      $this->price = $price;
  }

  function cmp($a, $b) {
    if($a->symbol == $b->symbol)
    {
      return DateUtils::convertMonthToNum(explode(' ',$a->date)[0]) > DateUtils::convertMonthToNum(explode(' ',$b->date)[0]);
    }
    return $a->symbol > $b->symbol;
  }
}
