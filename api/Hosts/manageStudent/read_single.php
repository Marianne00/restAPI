<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

<<<<<<< HEAD
    include_once '../../../config/Database.php';
    include_once '../../../models/Users.php';
=======
    include_once '../../config/Database.php';
    include_once '../../models/Users.php';
>>>>>>> b18f4c6cbd8b81b518ce9cc3d5fd742967a0e137

    //Instantiate Database Class
    $database = new Database();
    $db = $database->connect();

    //Instantiate Users Class
    $users = new Users($db); 

    //Get ID from URL
    $users->stud_id = isset($_GET['stud_id']) ? $_GET['stud_id'] : die();
<<<<<<< HEAD
=======
    
    //Get Post
>>>>>>> b18f4c6cbd8b81b518ce9cc3d5fd742967a0e137
    $users->singleStudent();

    //Create array
    $student_arr = array(
        'stud_id' => $users->stud_id,
<<<<<<< HEAD
        'name' => $users->name,
=======
        'fname' => $users->fname,
        'mname' => $users->mname,
        'lname' => $users->lname,
>>>>>>> b18f4c6cbd8b81b518ce9cc3d5fd742967a0e137
        'section' => $users->section_name
    );

    print_r(json_encode($student_arr));