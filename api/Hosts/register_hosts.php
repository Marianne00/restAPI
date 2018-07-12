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

    //HERE GOES VALIDATION

    if( $data->fname != '' &&
        $data->mname != '' &&
        $data->lname != '' &&
        $data->username != '' &&
        $data->password != '' &&
        $data->confirm_pw != ''){

        $hosts->boolAllFilled = true; 

        //PASSWORD LENGTH VALIDATION
        if(strlen($data->password) > 7){
            $hosts->boolPassword = true;
        }
        //CONFIRM PASSWORD MATCH VALIDATION
        if($data->password == $data->confirm_pw){
            $hosts->boolSamePassword = true;
        }

        if(strlen($data->username) > 14){
            $hosts->boolUsernameLen = true;
        }

        //USERNAME AVAILABILITY VALIDATION
        $specialCharCollection = " /[\'^£$%&*()}{@#~?><>,|=_+¬-]/ ";

        if(!preg_match($specialCharCollection, $data->username)){ // IF WALANG SPECIAL CHARACTERS

            $hosts->boolUsernameSpecialChar = true;

            $foundUsername = 0;

            $result = $hosts->getHosts();
                
            $rowcount = $result->rowCount();
            //IISA ISAHIN SA NAKUHANG RESULT KUNG NAGMATCH
            if($rowcount > 0){

                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    if($data->username == $username){
                        $foundUsername +=1;
                    }
                }

                if($foundUsername == 0){
                    $hosts->boolUsername = true;
                }

            }else{ // 
                $hosts->boolUsername = true;
            }

        }



    }


    if( $hosts->boolUsername == true && 
        $hosts->boolUsernameSpecialChar == true &&
        $hosts->boolPassword == true && 
        $hosts->boolSamePassword == true &&
        $hosts->boolAllFilled == true &&
        $hosts->boolUsernameLen == true){

        // SAVES THE RAW DATA TO THE HOSTS CLASS
        $hosts->fname = $data->fname;
        $hosts->mname = $data->mname;
        $hosts->lname = $data->lname;
        $hosts->username = $data->username;
        $hosts->password = $data->password;
        $hosts->confirm_password = $data->confirm_pw;

        // FUNCTION NA PUTANG INANG MAG SESEND SA DATABASE

        if ($hosts->registerHost()){
        echo json_encode(
            array('message' => 'Host registered successfully.')
        );
        }else{
            echo json_encode(
                array('message' => 'Host registration failed.')
            ); 
        }


    }else{
        echo json_encode(array(
            'boolAllFilled' => $hosts->boolAllFilled,
            'boolUsername' => $hosts->boolUsername,
            'boolUsernameLen' => $hosts->boolUsernameLen,
            'boolPassword' => $hosts->boolPassword,
            'boolboolSamePassword' => $hosts->boolSamePassword,
            'boolUsernameSpecialChar' => $hosts->boolUsernameSpecialChar
        ));
    }
    