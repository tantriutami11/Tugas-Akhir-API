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
		if(!isset($data->temperature) or !isset($data->humidity)){
			die('NULL data detected');
		}
		$item->id = $data->id;
		$item->temperature = $data->temperature;
		$item->humidity = $data->humidity;
		$item->waktu = date('Y-m-d H:i:s');
		
	} 
    elseif ($_SERVER['REQUEST_METHOD'] === 'GET'){
		$item->id = isset($_GET['id']) ? $_GET['id'] : die('wrong structure!');
		$item->temperature = isset($_GET['temperature']) ? $_GET['temperature'] : die('wrong structure!');
		$item->humidity = isset($_GET['humidity']) ? $_GET['humidity'] : die('wrong structure!');
		$item->waktu = date('Y-m-d H:i:s');
	}else {
		die('wrong request method');
	}
    
    if($item->updateDataLog()){
        echo json_encode("Log Data ".$item->id ." updated.");
    } else{
        echo json_encode("Data could not be updated");
    }
?>