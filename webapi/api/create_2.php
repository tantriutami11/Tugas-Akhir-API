<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../config/database.php';
    include_once '../class/nodemcu_log.php';

    $database = new Database();
    $db = $database->getConnection();

    $item = new Nodemcu_log($db);
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// The request is using the POST method
		$data = json_decode(file_get_contents("php://input"));
		$item->sensor_suhu = $data->sensor_suhu;
		$item->sensor_ph = $data->sensor_ph;
		$item->sensor_do = $data->sensor_do;
		$item->sensor_amonia = $data->sensor_amonia;
		$item->sensor_suhu_baterai = $data->sensor_suhu_baterai;
		$item->sensor_arus = $data->sensor_arus;
		$item->sensor_tegangan = $data->sensor_tegangan;
	} 
    elseif ($_SERVER['REQUEST_METHOD'] === 'GET'){
		// The request is using the GET method
		$item->sensor_suhu = isset($_GET['sensor_suhu']) ? $_GET['sensor_suhu'] : die('wrong structure!');
		$item->sensor_ph = isset($_GET['sensor_ph']) ? $_GET['sensor_ph'] : die('wrong structure!');
		$item->sensor_do = isset($_GET['sensor_do']) ? $_GET['sensor_do'] : die('wrong structure!');
		$item->sensor_amonia = isset($_GET['sensor_amonia']) ? $_GET['sensor_amonia'] : die('wrong structure!');
		$item->sensor_suhu_baterai = isset($_GET['sensor_suhu_baterai']) ? $_GET['sensor_suhu_baterai'] : die('wrong structure!');
		$item->sensor_arus = isset($_GET['sensor_arus']) ? $_GET['sensor_arus'] : die('wrong structure!');
		$item->sensor_tegangan = isset($_GET['sensor_tegangan']) ? $_GET['sensor_tegangan'] : die('wrong structure!');
	}else {
		die('wrong request method');
	}
	
    if($item->createLogData()){
        echo 'Data created successfully.';
    } else{
        echo 'Data could not be created.';
    }
?>