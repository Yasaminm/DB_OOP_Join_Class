<?php
require_once './config.php';
require_once './classes/DbClass.php';
require_once './classes/FilterForm.php';
try {   //DB connection:
            $db = new DbClass('mysql:host=' . HOST . ';dbname=' . DB, USER, PASSWORD);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $exc) {
                echo $exc->getCode();
            }
            
            $db->setTable('tb_services');
            $dataServices = $db->getAllData();
            
?>
<?php
           //hotel eintragen
           $filter = new FilterForm();
           $filter->setFilter('field_name', 513, 'name');
           $dataName = $filter->filter(INPUT_POST);
           
            if (count($dataName) === 1) {
            $db->setTable('tb_hotels');
            $db->insert($dataName);
            }
           
            //services eintragen. It is array
            $f2 = new FilterForm();
            $f2->setFilter('field_services', [FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY],'service_id');

            $dataFormServices = $f2->filter(0);
            
            $db->setTable('tb_hotel_service');
            $data = [];
            foreach ($dataFormServices as $key => $value) {
                for ($index = 0; $index < count($value); $index++) {
                    $data[$key] = $value[$index];
                    $db->insert($data);
                }
}
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
var_dump($dataFormServices);
?>
<?php  ?>
        </pre>
    </body>
</html>
