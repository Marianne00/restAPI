<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Quiz.php';

    // Instantiate Database Class
    $database = new Database();
    $db = $database->connect();

    // Instantiate Quiz Class
    $quiz = new Quiz($db);

    // Get Raw Data
    $data = json_decode(file_get_contents('php://input'));
<<<<<<< HEAD

    
=======
>>>>>>> b18f4c6cbd8b81b518ce9cc3d5fd742967a0e137
    
    $quiz->quizTitle = $data->quizTitle;
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
