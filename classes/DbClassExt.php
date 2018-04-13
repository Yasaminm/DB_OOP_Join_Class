<?php

class DbClassExt extends DbClass {

 public function insertArray(array $data = []) {
  //$data["service_id"] = [1,2,4]
  //$data["hotel_id"] = [1,1,1]
  $keys = array_keys($data);

  $amountValues = count($data[$keys[0]]);

  for ($i = 0; $i < $amountValues; $i++) {
   $tmp = [];
   for ($j = 0; $j < count($keys); $j++) {
    //$tmp['hotel_id'] = $data['hotel_id'][0]
    //$tmp['service_id'] = $data['service_id'][0]
    $tmp[$keys[$j]] = $data[$keys[$j]][$i];
   }
   $this->insert($tmp);
  }
 

        //Schleife
        //$row['hotel_id'] = 1
        //$row['service_id'] = 2
        //$this->insert($row);
        //Schleife Ende
    }
}
