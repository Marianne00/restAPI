<?php

    class Hosts {
        //Database Properties 
        private $conn;
        private $tblname = "students";
        
        //Student Properties
        public $new_id;
        public $stud_id;
        public $section_id;
        public $section_name;
        public $fname; 
        public $mname;
        public $lname;
        
        //Constructor
        public function __construct($db){
            $this->conn = $db;
        }
        
        
    }