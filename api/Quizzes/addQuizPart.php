<?php

    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Quiz.php';
    include_once '../../controllers/ErrorController.php';

    //Instantiate Database Class
    $database = new Database();
    $db = $database->connect();
    $quizzes = new Quiz($db);
    $errorCont = new ErrorController();

    //Get Raw Data
    $data = json_decode(file_get_contents('php://input'));

    if($errorCont->checkField($data->type_name, 'Type Name')){
        if($errorCont->checkField($data->quizTitle, 'Quiz Title')){
            if($errorCont->checkField($data->part_title, 'Part Title')){
                if($errorCont->checkField($data->duration, 'Duration')){
                    if($errorCont->numbersOnly($data->duration, 'Duration')){
                        $quizzes->type_name = $data->type_name;
                        $quizzes->quizTitle = $data->quizTitle;
                        $quizzes->part_title = $data->part_title;
                        $quizzes->duration = $data->duration;

                        $quizzes->getQuizID();

                        if($quizzes->countParts() >=4) {
                            echo json_encode(
                                array('message' => 'Your quiz can only have a maximum of 4 parts.')
                            );

                        }elseif($quizzes->countParts()  < 4){
                            $quizzes->getTypeID();

                            //Create
                            $quizzes->totalParts += 1;
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
                    }
                }
            }
        }
    }  
      
    

    if($errorCont->errors != null){
        echo json_encode(
            $errorCont->errors
        );
    }
    
    

    

?>