<?php
require_once './config.php';
require_once './classes/DbClass.php';
require_once './classes/FilterForm.php';
require_once './classes/DbClassExt.php';
try {   //DB connection:
            $db = new DbClassExt('mysql:host=' . HOST . ';dbname=' . DB, USER, PASSWORD);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $exc) {
                echo $exc->getCode();
            }
            
            $db->setTable('tb_services');
            $dataServices = $db->getAllData();
            
?>
<?php

            $lastId = null;
            
           //Filter field_name
           $f = new FilterForm();
           $f->setFilter('field_name', 513, 'name');
           $dataName = $f->filter(INPUT_POST);
           
           //Hotelname eintragen
            if (count($dataName) === 1) {
            $db->setTable('tb_hotels');
            $lastId = $db->insert($dataName); //$dataName['name'] = 'Hotel name in input';
            }
            
            if ($lastId > 0){
                //services eintragen. It is array
            $f2 = new FilterForm();
            $f2->setFilter('field_services', [FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY],'service_id');
            $dataFormServices = $f2->filter(0); //$dataFormServices = ['service_id' => [1, 2, 4]]
            
            if (count($dataFormServices) > 0) {
            $dataFormServices['hotel_id'] = [];
            for ($i = 0; $i < count($dataFormServices['service_id']); $i++) {
                $dataFormServices['hotel_id'][] = $lastId;
                
            }
             $db->setTable('tb_hotel_service');
           $result =  $db->insertArray($dataFormServices);
           }
            }
           
           
            
            //////////////////////////////////
//            $db->setTable('tb_hotel_service');
//            $data = [];
//            foreach ($dataFormServices as $colName => $values) {
//                for ($i = 0; $i < count($values); $i++) {
//                    $data[$colName] = $values[$i]; // $data['service_id] = 2
//                    $data['hotel_id'] = $lastId; // $data['hotel_id'] = 1
//                    $db->insert($data);
//                }
//}
             /////////////////////////////////////////////
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>PHP 13 Hotels DB</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="assets/css/styles.css">    
        <script src="assets/js/jquery-3.3.1.min.js" type="text/javascript"></script>
        <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="assets/js/main.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="container">
            <form method="post" action="index.php">
                <div class="form-group">
                    <hr>
                    <h3>Hotels and related Services</h3>
                    <hr>
                    <label for="field_name">Hotel Name:</label>
                    <input type="text" value="Nice Hotel" class="form-control" id="field_name" name="field_name"  placeholder="Hotel Name">
                </div>
                <?php foreach ($dataServices as $key => $value): ?>
                <div class="form-check form-check-inline">
                    <input type="checkbox" name="field_services[]" class="form-check-input" id="service<?php echo $value['id'] ?>" value="<?php echo $value['id'] ?>">
                    <label class="form-check-label" for="service<?php echo $value['id'] ?>"><?php echo $value['de'] ?></label>
                </div>
                <?php endforeach;  ?>
                <div class="form-group">
                    <button type="submit" class="btn btn-outline-primary">Save</button>
                </div>
            </form>
        </div>
 <pre>
<?php   
var_dump($result);
?>
<?php  
//inserts mit assoziativen Arrays
//$data = [];
////     column = wert
//$data['name'] = 'Westin Grand';
//$data['de'] = 'Swimmingpool';
//$db->insert($data);
//
////inserts mit zweidimensionalen Arrays
//$data = [];
//$data['service_id'] = [2,5];
////$db->insertArray($data);


//$data = [
//    'hotel_id' => [1,1,1],
//    'service_id' => [1,2,4]
//]
//prüfen ob post variable vorhanden
//Einfügen in die hotel tabelle
?>
        </pre>
    </body>
</html>
