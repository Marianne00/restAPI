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

    $data->type_name = $quiz->type_name;
    $data->quiz_name = $quiz->quizTitle;
    $data->part_title = $quiz->part_title;
    $data->position = $quiz->position;

    $quiz->getTypeID();
    $quiz->getQuizID();