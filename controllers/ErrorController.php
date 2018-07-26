<?php

    class ErrorController {
        
        public $errors = array();
        public $name;
        
        
        public function UpStudentFields($student_id, $section_name, $fname, $lname){
            if($student_id == ""){
                $this->errors['field'] = "Student ID";
                $this->errors['message'] = "All fields are required";
            }elseif($section_name == ""){
                $this->errors['field'] = "Section Name";
                $this->errors['message'] = "All fields are required";
            }elseif($fname == ""){
                $this->errors['field'] = "First Name";
                $this->errors['message'] = "All fields are required";
            }elseif($lname == ""){
                $this->errors['field'] = "Last Name";
                $this->errors['message'] = "All fields are required";
            }else{
                return true;
            }
        }

        public function UpHostRegisterFields($host_fname,$host_lname,$host_username,$host_pass,$host_repass){
            if($host_fname == "" ){
                $this->errors['field'] = "Host FirstName";
                $this->errors['message'] = "All fields are required";
            }elseif($host_lname == "" ){
                $this->errors['field'] = "Host LastName";
                $this->errors['message'] = "All fields are required";
            }elseif($host_username == "" ){
                $this->errors['field'] = "Host Username";
                $this->errors['message'] = "All fields are required";
            }elseif($host_pass == "" ){
                $this->errors['field'] = "Host Password";
                $this->errors['message'] = "All fields are required";
            }elseif($host_repass == "" ){
                $this->errors['field'] = "Host Retype Password";
                $this->errors['message'] = "All fields are required";
            }else{
                return true;
            }
        }
        
        public function validateStudentID($student_id, $field){

            if (!preg_match('/^[0-9]*$/', $student_id)) {
                $this->errors['field'] = $field;
                $this->errors['message'] = "Student ID must be numbers only";
            }elseif(strlen($student_id)>10){
                $this->errors['field'] = $field;
                $this->errors['message'] = "Student ID must only contain 10 numbers";
            }else{
                return true;
            }

        }
        
        public function validateName($fname, $mname, $lname) {
            if (!preg_match("/^[a-zA-Z ]*$/",$fname)) {
                $this->errors['field'] = "First Name";
            }elseif(!preg_match("/^[a-zA-Z ]*$/",$mname)) {
                $this->errors['field'] = "Middle Name";
            }elseif(!preg_match("/^[a-zA-Z ]*$/",$lname)) {
                $this->errors['field'] = "Last Name";
            }
            
            if($this->errors['field'] != null) {
                $this->errors['message'] = "Name must only contain letters";
            }else{
                return true;
            }
        }
        
        public function numbersOnly($string, $field){
            if(is_numeric($string)){
                return true;
            }else{
                $this->errors['field'] = $field;
                $this->errors['message'] = "Numbers only";
            }
        }
        
        public function checkField($string, $field){
            if($string == "") {
                $this->errors['field'] = $field;
                $this->errors['message'] = "All fields are required";
            }else{
                return true;
            }
        }

        public function checkLength($password,$field,$desired_len){
            if(strlen($password) < $desired_len){
                $this->errors['field'] = $field;
                $this->errors['message'] = $field." length must be ".$desired_len;
            }elseif (strlen($password) >= $desired_len){
                return true;
            }
        }

        public function checkHaveSpecialChar($checkee,$field){
             if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $checkee)){
                $this->errors['field'] = $field;
                $this->errors['message'] = $field." has special character ";
            }else{
                return true;
            }
        }

        public function checkIfMatch($checkee1,$checkee2,$field){
            if( $checkee1 != $checkee2 ){
                $this->errors['field'] = $field;
                $this->errors['message'] = "Does no match";
            }else{
                return true;
            }
        }

    }