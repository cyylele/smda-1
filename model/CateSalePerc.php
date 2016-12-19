<?php
class CateSalePerc
{
  var $category;
  var $sale_amount;
  var $percentage;

  function setCategory ($category) {
      $this->category = $category;
  }
  function setSaleAmount ($sale_amount) {
      $this->sale_amount = $sale_amount;
  }
  function setPercentage ($percentage) {
      $this->percentage = $percentage;
  }

  function cmp($a, $b) {
    return $a->sale_amount < $b->sale_amount;
  }
}
