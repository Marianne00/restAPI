<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
    include_once '../../config/Database.php';
    include_once '../../models/Hosts.php';
    include_once '../../controllers/ErrorController.php';
    //Instantiate Database Class
    $database = new Database();
    $db = $database->connect();
    //Instantiate Users Class
    $hosts = new Hosts($db);
    //Instatiate Error Controller
    $errorCont = new ErrorController();
    //Get Raw Data
    $data = json_decode(file_get_contents('php://input'));
    
  
    if($errorCont->checkField($data->fname, 'Host Firstname')){
        if($errorCont->checkField($data->lname, 'Host Lastname')){
            if($errorCont->checkField($data->username, 'Host Username')){
                if($errorCont->checkField($data->password, 'Host Password')){
                    if($errorCont->checkField($data->confirm_pw, 'Host Retype Password')){
                        if($errorCont->checkHaveSpecialChar($data->username,"Host Username")){
                            if($errorCont->checkMinLength($data->username,"Host Username",10)){
                                if($errorCont->checkIfMatch($data->password,$data->confirm_pw,"Host Password")){
                                    if($errorCont->checkMinLength($data->password,"Host Password",10)){
                                        $hosts->fname = $data->fname;
                                        $hosts->mname = $data->mname;
                                        $hosts->lname = $data->lname;
                                        $hosts->username = $data->username;
                                        $hosts->password =  $data->password;

                                        if($hosts->registerHost()){
                                            echo json_encode(
                                                array('message' => 'Host Registration Success.')
                                            );
                                        }else{
                                            echo json_encode(
                                                array('message' => 'Host Registration Failed.')
                                            );
                                        }
                                    }
                                }  
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

    ?>


    