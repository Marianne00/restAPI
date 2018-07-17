<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Quiz.php';

    //Instantiate Database Class
    $database = new Database();
    $db = $database->connect();

    //Instantiate Users Class
    $quiz = new Quiz($db); 

    //Get Raw Data
    $data = json_decode(file_get_contents('php://input'));

    //Set ID
    $quiz->quizID = $data->quizID;

    $quiz->quizTitle = $data->quizTitle;
    $quiz->parts = $data->parts;

    
    //$users->getStudentSection();

    
    //Update
    if ($quiz->updateQuiz()){
        echo json_encode(
            array('message' => 'Quiz updated successfully.')
        );
    }else{
        echo json_encode(
            array('message' => 'Quiz update failed.')
        ); 
    }