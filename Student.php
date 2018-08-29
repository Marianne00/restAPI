<?php

class Student extend Model
{
    public function __construct($id) {
        
    }
}

class Model 
{
    
    
    public function __construct() {
        // Connect to DB
    }
    
    public static function find($id) {
        return new Student($id);
    }
}
