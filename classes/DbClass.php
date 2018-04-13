<?php

class DbClass extends PDO {

 private $tableName = '';

 public function setTable($tn) {
  $this->tableName = $tn;
 }

 public function getAllData() {
  try {
   $stmt = $this->query("SELECT * FROM $this->tableName");
   $rows = $stmt->fetchall(PDO::FETCH_BOTH);
   return $rows;
  } catch (Exception $exc) {
   echo 'ERROR: getAllData() ' . $exc->getCode();
   exit();
  }
 }

 public function delete($value, $colName = 'id') {
  $query = "DELETE FROM $this->tableName WHERE $colName=:value";
  try {
   $stmt = $this->prepare($query);
   $stmt->bindValue(':value', $value);
   $stmt->execute();
  } catch (Exception $exc) {
   echo 'ERROR: delete() ' . $exc->getCode();
  }
 }

 public function insert($data) {
  $i = 0;
  $cols = [];
  $vals = [];
  foreach ($data as $col => $value) {
   $cols[] = $col;
   $vals[] = '?';
  }
  $query = sprintf("INSERT INTO %s (%s) VALUES (%s)", $this->tableName, implode(',', $cols), implode(',', $vals));

  $st = $this->prepare($query);
  foreach ($data as $value) {
   $st->bindValue(++$i, $value);
  }
  $st->execute();
  return $this->lastInsertId();
 }

 public function update($data, $valWhere, $colWhere = 'id') {
  $i = 0;
  $sets = [];

  foreach ($data as $col => $value) {
   $sets[] = "$col=?";
  }

  $query = sprintf("UPDATE %s SET %s WHERE %s='%s'", $this->tableName, implode(',', $sets), $colWhere, $valWhere);
  $st = $this->prepare($query);

  foreach ($data as $value) {
   $st->bindValue(++$i, $value);
  }

  $st->execute();
 }

}
