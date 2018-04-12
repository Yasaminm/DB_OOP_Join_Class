<?php

class FilterForm {

 private $scheme = [];

 public function __construct() {
  
 }

 public function setFilter(string $field, int $filter, $column = false) {
  $c = (!$column) ? $field : $column;
  $this->scheme[] = [
      'fieldname' => $field,
      'columname' => $c,
      'filter' => $filter
  ];
 }

 public function getScheme() {
  return $this->scheme;
 }

 public function filter($method) {
  $data = [];
  foreach ($this->scheme as $item) {
   $val = filter_input($method, $item['fieldname'], $item['filter']);
   if ($val !== false && $val !== NULL) {
    $data[$item['columname']] = $val;
   }
  }
  return $data;
 }

}
