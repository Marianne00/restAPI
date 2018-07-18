<?php 
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Quiz.php';

    //Instantiate Database Class
    $database = new Database();
    $db = $database->connect();

    //Instantiate Quiz Class
    $quiz = new Quiz($db); 

    //Get Raw Data
    $data = json_decode(file_get_contents('php://input'));
 	
 	//SET THE QUIZ VARIABLES VIA $DATA
    $quiz->newPartTitle =  $data->newPartTitle;
    $quiz->newPartType = $data->newPartType;
    $quiz->updateId = $data->updateId;

    if( $quiz->updateQuizPart() ){

    	echo json_encode(
            array('message' => 'Quiz Part updated successfully.')
        );

    }else{

    	echo json_encode(
            array('message' => 'Quiz Part not Updated.')
        );
    }






?>