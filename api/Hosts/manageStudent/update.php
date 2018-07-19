<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

     include_once '../../../config/Database.php';
    include_once '../../../models/Users.php';

    //Instantiate Database Class
    $database = new Database();
    $db = $database->connect();

    //Instantiate Users Class
    $users = new Users($db); 

    //Get Raw Data
    $data = json_decode(file_get_contents('php://input'));

    //Set ID
    $users->new_id = $data->id;

    $users->student_id = $data->student_id;
    $users->section_name = $data->section_name;
    $users->fname = $data->fname;
    $users->mname = $data->mname;
    $users->lname = $data->lname;

    
    $users->getStudentSection();

    
    //Create
    if ($users->updateStudent()){
        echo json_encode(
            array('message' => 'Student update completed.')
        );
    }else{
        echo json_encode(
            array('message' => 'Student update failed.')
        ); 
    }