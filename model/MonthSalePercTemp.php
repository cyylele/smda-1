<?php
class MonthSalePercTemp
{
  var $month;
  var $month_sales;
  var $month_percentage;
  var $temperature;

  function setMonth ($month) {
      $this->month = $month;
  }
  function setMonthSales ($month_sales) {
      $this->month_sales = $month_sales;
  }
  function setMonthPercentage ($month_percentage) {
      $this->month_percentage = $month_percentage;
  }
  function setTemperature ($temperature) {
      $this->temperature = $temperature;
  }
}
