<?php
class BrandSalePercTemp
{
  var $brand;
  var $sale_amount;
  var $percentage;
  var $temperature;

  function setBrand ($brand) {
      $this->brand = $brand;
  }
  function setSaleAmount ($saleAmount) {
      $this->sale_amount = $saleAmount;
  }
  function setPercentage ($percentage) {
      $this->percentage = $percentage;
  }
  function setTemperature ($temperature) {
      $this->temperature = $temperature;
  }
  function cmp($a, $b) {
    return $a->sale_amount < $b->sale_amount;
  }
}
