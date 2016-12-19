<?php
class CateDateProp
{
  var $category;
  var $date;
  var $category_proportion;

  function setCategory ($category) {
      $this->category = $category;
  }
  function setDate ($date) {
      $this->date = $date;
  }
  function setCategoryProportion ($category_proportion) {
      $this->category_proportion = $category_proportion;
  }

  function cmp($a, $b) {
    return $a->category_proportion < $b->category_proportion;
  }
}
