<?php 
   //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
    include_once '../../config/Database.php';
    include_once '../../models/Hosts.php';
    include_once '../../controllers/ErrorController.php';
    //Instantiate Database Class
    $database = new Database();
    $db = $database->connect();
    //Instantiate Users Class
    $hosts = new Hosts($db);
    //Instatiate Error Controller
    $errorCont = new ErrorController();
    //Get Raw Data
    $data = json_decode(file_get_contents('php://input'));

    // di ko na vavalidate yung quiz_id saka part_id kasi sa form na matic mangagaling yon
   	if($errorCont->checkField($data->question,"Question Field",1,1000)){
   		if($errorCont->checkField($data->answer,"Answer Field",1,100)){
   			
   			if ($hosts->addGuessQuestion($data->quiz_id, $data->part_id, $data->question , $data->answer) ){
   				echo json_encode(
                	array('message' => 'Question Successfully Added')
                );
   			}else{
   				echo json_encode(
                	array('message' => 'Question Adding Failed')
                );
   			}
   		}
   	}

   	if($errorCont->errors != null){
   		echo json_decode( $errorCont->errors );
   	}


?>