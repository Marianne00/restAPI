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

    //Instantiate Users Class
    $quizzes = new Quiz($db);

    //Get Raw Data
    $data = json_decode(file_get_contents('php://input'));
    
    $quizzes->type_name = $data->type_name;
    $quizzes->quizTitle = $data->quizTitle;
    $quizzes->part_title = $data->part_title;
    $quizzes->position = $data->position;
    $quizzes->duration = $data->duration;

    $quizzes->getQuizID();
    
    if($quizzes->countParts() >=4) {
        echo json_encode(
            array('message' => 'Your quiz can only have a maximum of 4 parts.')
        );
        
    }elseif($quizzes->countParts()  < 4){
        $quizzes->getTypeID();

        //Create
        if ($quizzes->addQuizPart()){
            echo json_encode(
                array('message' => 'Quiz part added.',
                      'num parts' => $quizzes->countParts() 
                     )
            );
        }else{
            echo json_encode(
                array('message' => 'There is an error.')
            ); 
        }
    }

    

?>