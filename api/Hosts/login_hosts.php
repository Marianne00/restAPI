<?php 
	//Headers
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	include_once '../../config/Database.php';
	include_once '../../models/Hosts.php';

    $errors = array();

	//Instantiate Database Class
	$database = new Database();
	$db = $database->connect();

	//Instantiate Hosts
	$hosts = new Hosts($db);

	//GETS THE SENT DATA
	$data = json_decode(file_get_contents('php://input'));

    if($data->sent_username == ""){
       echo json_encode (array(
        "field" => "username",
        "message" => "all fields are required"
       ));
    }elseif($data->sent_password == ""){
        echo json_encode (array(
        "field" => "password",
        "message" => "all fields are required"
       ));
    }else{
        $hosts->username = $data->sent_username; 
        $hosts->password = $data->sent_password;
        if ($hosts->logInHost()){
            echo json_encode (array(
                "message" => "Access granted"
            ));
        }else{
             echo json_encode (array(
                "message" => "Access denied"
            ));
        }

    }


  	
  	
?>