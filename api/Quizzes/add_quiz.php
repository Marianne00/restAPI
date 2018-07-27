<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Quiz.php';
    include_once '../../controllers/ErrorController.php';

    // Instantiate Classes
    $database = new Database();
    $db = $database->connect();
    $quiz = new Quiz($db);
    $errorCont = new ErrorController();
    

    // Get Raw Data
    $data = json_decode(file_get_contents('php://input'));

    if($errorCont->checkField($data->quizTitle, 'Quiz Title', 0, 251)){
        if($data->description != "") {
            if($errorCont->checkField($data->description, 'Description', 0, 151)){
                $quiz->quizTitle = $data->quizTitle;
                $quiz->description = $data->description;
                $quiz->kunware_session = $data->hostID;

                // Create
                if ($quiz->addQuiz()) {
                    echo json_encode(
                        array('message' => 'Quiz created successfully!')
                    );
                } else {
                    echo json_encode(
                        array('message' => 'Failed to create quiz!')
                    );
                }
            }
        }else{
            $quiz->quizTitle = $data->quizTitle;
                $quiz->description = $data->description;
                $quiz->kunware_session = $data->hostID;

                // Create
                if ($quiz->addQuiz()) {
                    echo json_encode(
                        array('message' => 'Quiz created successfully!')
                    );
                } else {
                    echo json_encode(
                        array('message' => 'Failed to create quiz!')
                    );
                }
        }
    }

    if($errorCont->errors != null) {
        echo json_encode (
            $errorCont->errors  
        );
    }
