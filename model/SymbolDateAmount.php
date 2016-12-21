<?php
include_once('utils/DateUtils.php');

class SymbolDateAmount
{
  var $symbol;
  var $dateTime;
  var $amount;

  function setSymbol ($symbol) {
      $this->symbol = $symbol;
  }
  function setDate ($date) {
      $this->dateTime = $date;
  }
  function setAmount ($amount) {
      $this->amount = $amount;
  }

  function cmp($a, $b) {
    if($a->symbol == $b->symbol)
    {
      return DateUtils::convertMonthToNum(explode(' ',$a->dateTime)[0]) > DateUtils::convertMonthToNum(explode(' ',$b->dateTime)[0]);
    }
    return $a->symbol > $b->symbol;
  }
}
