<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

    include_once '../../../config/Database.php';
    include_once '../../../models/Users.php';
    include_once '../../../controllers/ErrorController.php';

    //Instantiate Classes
    $database = new Database();
    $db = $database->connect();
    $users = new Users($db); 
    $errorCont = new ErrorController();

    $errors = array();

    //Get Raw Data
    $data = json_decode(file_get_contents('php://input'));


    if($errorCont->checkField($data->student_id, 'Student ID', 10, 11)){
         if($errorCont->checkField($data->section_name, 'Section Name', 0, 100)){
             if($errorCont->checkField($data->fname, 'First Name', 1, 100)){
                 if($errorCont->checkField($data->lname, 'Last Name', 1, 100)){
                     if($errorCont->validateStudentID($data->student_id, 'Student_ID')){
                        if($errorCont->validateName($data->fname, $data->mname, $data->lname)){
                            if(!$users->verifyStudentID($data->student_id)){
                                $users->student_id = $data->student_id;
                                $users->section_name = $data->section_name;
                                $users->fname = $data->fname;
                                $users->mname = $data->mname;
                                $users->lname = $data->lname;

                                $users->getStudentSection();

                                //Create
                                if ($users->registerStudent()){
                                    echo json_encode(
                                        array('message' => 'Student registered successfully.')
                                    );
                                }else{
                                    echo json_encode(
                                        array('message' => 'Student registration failed.')
                                    ); 
                                }
                            
                            }else{
                                echo json_encode(
                                    array(
                                        'field' => 'Student ID',
                                        'message' => 'Student ID already exists'
                                    )
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
    
    
    
