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

    //Question Query
    $result = $quiz->readQuestions();
        
    //Get Row Count of Questions
    $rowcount = $result->rowCount();

 if($rowcount>0){
   
        // Users array
        $quiz_arr = array();
        $quiz_arr['data'] = array();
    
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $quiz_item = array (
               'Question:' => $question,
                'a' => $choice1,
                'b' => $choice2,
                'c' => $choice3,
                'd' => $choice4,
                'Answer:' => $rightAnswer
            );
            //Push to data array 
            array_push($quiz_arr['data'], $quiz_item);
        }
        //Convert to JSON
        echo json_encode($quiz_arr);
        
    }else{
        // No Questions
        echo json_encode(array(
            'message' => 'No Questions Created.'
        ));
    }