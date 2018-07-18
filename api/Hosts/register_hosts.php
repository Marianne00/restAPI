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
        }else{
            $hosts->boolPassword = false;
        }
        //CONFIRM PASSWORD MATCH VALIDATION
        if($data->password == $data->confirm_pw){
            $hosts->boolSamePassword = true;
        }else{
            $hosts->boolSamePassword = false;
        }

        if(strlen($data->username) > 9){
            $hosts->boolUsernameLen = true;
        }else{
            $hosts->boolUsernameLen = false;
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
                }else{
                    $hosts->boolUsername = false;
                }
            }else{ // 
                $hosts->boolUsername = true;
            }
        }else{
            $hosts->boolUsernameSpecialChar = false;
        }

    }else{
        $hosts->boolAllFilled = false; 
    }

    //CHECKING IF THE SENT DATA IS OKAY
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

        //FUNCTION TO SEND THE SENT DATA TO DATABASE
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
            'boolSamePassword' => $hosts->boolSamePassword,
            'boolUsernameSpecialChar' => $hosts->boolUsernameSpecialChar
        ));
    }

    ?>