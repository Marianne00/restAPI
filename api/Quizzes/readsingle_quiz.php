<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Quiz.php';

    //Instantiate Database Class
    $database = new Database();
    $db = $database->connect();

    //Instantiate Quiz Class
    $quiz = new Quiz($db); 

    //Get ID from URL
    $quiz->quizTitle = isset($_GET['quizTitle']) ? $_GET['quizTitle'] : die();
    
    //Get Post
    $quiz->singleQuiz();

    //Create array
    $quiz_arr = array(
        'quizID' => $quiz->quizID,
        'quizTitle' => $quiz->quizTitle,
        'quizParts' => $quiz->parts,
        'date_created' => $quiz->date_created,
        'quizAdmin' => $quiz->fname
    );

    print_r(json_encode($quiz_arr));