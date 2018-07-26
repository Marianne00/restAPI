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
    }