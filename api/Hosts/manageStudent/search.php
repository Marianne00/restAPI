<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../../config/Database.php';
    include_once '../../../models/Users.php';

    //Instantiate Database Class
    $database = new Database();
    $db = $database->connect();

    //Instantiate Users Class
    $users = new Users($db); 
    
<<<<<<< HEAD
    $users->keyword =  $_GET['key'];

=======
>>>>>>> b18f4c6cbd8b81b518ce9cc3d5fd742967a0e137
    //Get Post
    $result = $users->searchStudent();

   //Get Row Count of Students
    $num = $result->rowCount();
   
    if($num>0){
        // Users array
        $users_arr = array();
        $users_arr['data'] = array();
        
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
<<<<<<< HEAD
            
            $user_item = array (
                'student_num' => $row['student_id'],
                'fname' => $row['fname'],
                'mname' => $row['mname'],
                'lname' => $row['lname'], 
                'fullname' => $row['fullname'],
                'section' => $row['section'],
                'key' => $users->keyword
=======
            extract($row);
            $user_item = array (
                'student_num' => $student_id,
                'fname' => $fname,
                'mname' => $mname,
                'lname' => $lname, 
                'section' => $section
>>>>>>> b18f4c6cbd8b81b518ce9cc3d5fd742967a0e137
            );
        
            //Push to data array 
            array_push($users_arr['data'], $user_item);
        }
        
        //Convert to JSON
        echo json_encode($users_arr);
    }else{
        // No students
        echo json_encode(array(
            'message' => 'No students enrolled to quizzen yet.'
        ));
    }