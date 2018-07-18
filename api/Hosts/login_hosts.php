<?php 
	//Headers
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	include_once '../../config/Database.php';
	include_once '../../models/Hosts.php';

	//Instantiate Database Class
	$database = new Database();
	$db = $database->connect();

	//Instantiate Hosts
	$hosts = new Hosts($db);

	//GETS THE SENT DATA
	$data = json_decode(file_get_contents('php://input'));

	//SETS THE VARIABLES OF OBJ HOST FOR EXECUTING QUERY
    $hosts->username = $data->sent_username; 
    $hosts->password = $data->sent_password;
  	
  	echo ($hosts->logInHost());
?>