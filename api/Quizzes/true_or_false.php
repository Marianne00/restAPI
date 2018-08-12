<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Quiz.php';
    include_once '../../controllers/ErrorController.php';

    $database = new Database();
    $db = $database->connect();
    $quiz = new Quiz($db);
    $errorCont = new ErrorController();
    $data = json_decode(file_get_contents('php://input'));

    if($errorCont->checkField($data->question, 'Question', 0, 1001)){
         if($errorCont->checkField($data->correct, 'Answer', 0, 201)){
                 $quiz->quizID = $data->quiz_id;
                 $quiz->part_id = $data->part_id;
                 $quiz->question = $data->question;
                 $quiz->correct = $data->correct;
                             
                    if($quiz->addQuestionToTrueOrFalse()){
                        if($quiz->insertAnswerforTrueorFalse()){
                            echo json_encode(
                                array(
                                    'message' => 'Question added successfully'
                                     )
                                        );
                                    }else{
                                        echo json_encode(
                                            array(
                                                'message' => 'There is an error in inserting the correct answer.'
                                            )
                                        );
                                    }                                    
                                }else{  
                                     echo json_encode(
                                        array(
                                            'message' => 'There is an error in adding questions'
                                        )
                                    );
                                }
                           }
                       }
            if($errorCont->errors != null) {
                echo json_encode(
                    $errorCont->errors
                );
            }