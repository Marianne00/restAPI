<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Hosts.php';

    //Instantiate Database Class
    $database = new Database();
    $db = $database->connect();

    //Instantiate Users Class
    $hosts = new Hosts($db);

    //Get Raw Data
    $data = json_decode(file_get_contents('php://input'));

    $hosts->admin_id = $data->admin_id;
    $hosts->fname = $data->fname;
    $hosts->mname = $data->mname;
    $hosts->lname = $data->lname;
    $hosts->username = $data->username;
    $hosts->password = $data->password;
    $hosts->confirm_password = $data->confirm_pw;
    
    //Create
    if ($hosts->addHost()){
        echo json_encode(
            array('message' => 'Host registered successfully.')
        );
    }else{
        echo json_encode(
            array('message' => 'Host registration failed.')
        ); 
    }