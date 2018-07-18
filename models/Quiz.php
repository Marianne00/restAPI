<?php

    Class Quiz {
        // Database Properties
        private $conn;
        private $tblname1 = "quiz";
        private $tblname2 = "hosted_quizzes";

        // Quiz Properties
        public $quizID;
        public $quizTitle;
        public $parts;
        public $hosted_id;
        public $admin_id;
        public $fname;
        public $date_created;
        public $kunware_session = 69;
        
        //Quiz Part Properties
        public $type_id;
        public $type_name;
        public $part_title;
        public $position;
        public $totalParts;
        public $duration;
        
        // Constructor
        public function __construct($db) {
            $this->conn = $db;
        }

        public function addQuiz() {
            $insertQuery = "INSERT INTO quiz
                            SET
                              quizTitle = :quizTitle,
                              parts = :parts
                              ";

            // Prepare Insert Statement
            $stmt = $this->conn->prepare($insertQuery);

            // Clean inputted data
            $this->quizTitle = htmlspecialchars(strip_tags($this->quizTitle));
            $this->parts = htmlspecialchars(strip_tags($this->parts));

            // Bind parameters
            $stmt->bindParam(':quizTitle', $this->quizTitle);
            $stmt->bindParam(':parts', $this->parts);

            // Execute
            if ($stmt->execute()) {
                $this->toMiddleMan();
                return true;
            } else {
                printf("Error %s". \n, $stmt->err);
                return false;
            }
        }

        public function toMiddleMan() {
            // Get latest created quiz
            $query = "SELECT MAX(quizID) FROM quiz";

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Execute Query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->quizID = $row['MAX(quizID)'];

            // Middle Man ;-;
            $insertQuery = "INSERT INTO hosted_quizzes
                            SET
                              quiz_id = :quiz_id,
                              admin_id = :admin_id
                              ";

            // Prepare Statement
            $stmt = $this->conn->prepare($insertQuery);

            // Bind parameters
            $stmt->bindParam(':quiz_id', $this->quizID);
            $stmt->bindParam(':admin_id', $this->kunware_session);

            // Execute
            if ($stmt->execute()) {
                return true;
            } else {
                printf("Error %s". \n, $stmt->err);
                return false;
            }
        }
 //Read Quiz
        public function readQUiz() {
            //Create query
            $query = "SELECT 
            a.quizID,
            a.quizTitle,
            a.parts,
            a.date_created, 
            b.fname 
            FROM 
            quiz a left join admins b 
            on a.quizID = b.admin_id
                ORDER BY
                    a.quizID ASC";
            
            //Prepare Statement
            $stmt = $this->conn->prepare($query);
              
            //Execute Query
            $stmt->execute();
            
            return $stmt;
        }
        
         //Get Single Quiz
         public function singleQuiz() {
            //Create query
            $query = 
            "SELECT 
            a.quizID,
            a.quizTitle,
            a.parts,
            a.date_created, 
            b.fname 
            FROM 
            quiz a left join admins b 
            on a.quizID = b.admin_id
                WHERE 
                    a.quizTitle = ?";
            
            //Prepate Statement
            $stmt = $this->conn->prepare($query);
             
            //Bind Student_ID
            $stmt->bindParam(1, $this->quizTitle);
            
            //Execute Query
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
             
            //Set student properties
            $this->quizID = $row['quizID'];
            $this->quizTitle = $row['quizTitle'];
            $this->parts = $row['parts'];
            $this->date_created = $row['date_created'];
            $this->fname = $row['fname'];  
        }
        
         //Update
       public function updateQuiz() {
        $insertQuery = 'UPDATE quiz
                        SET
                          quizTitle = :quizTitle,
                          parts = :parts
                          WHERE
                          quizID = :quizID';

       // Prepare Insert Statement
       $stmt = $this->conn->prepare($insertQuery);

        // Clean inputted data
       $this->quizTitle = htmlspecialchars(strip_tags($this->quizTitle));
       $this->parts = htmlspecialchars(strip_tags($this->parts));
       $this->quizID = htmlspecialchars(strip_tags($this->quizID));

        // Bind parameters
        $stmt->bindParam(':quizTitle', $this->quizTitle);
        $stmt->bindParam(':parts', $this->parts);
        $stmt->bindParam(':quizID', $this->quizID);

        // Execute
        if ($stmt->execute()) {
            return true;
        } else {
            printf("Error %s". \n, $stmt->err);
            return false;
        }
        }
        public function searchQuiz() {
            //Select query
            $query = 
            "SELECT 
            a.quizID,
            a.quizTitle,
            a.parts,
            a.date_created, 
            b.fname 
            FROM 
            quiz a left join admins b 
            on a.quizID = b.admin_id
                WHERE 
                  a.quizTitle LIKE '%".$_GET['quizTitle']."%'";
            
             //Prepare Statement   
            $stmt = $this->conn->prepare($query);
            
            //Execute Query
            $stmt->execute();
            
            return $stmt;
        }
        
        public function getQuizID() {
            $query = "SELECT quiz_id FROM quizzes WHERE quiz_title = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->quizTitle);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->quiz_id = $row['quiz_id'];
        }
        
        public function getTypeID() {
            $query = "SELECT type_id FROM question_types WHERE type = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->type_name);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->type_id = $row['type_id'];
        }
        
        public function countParts() {
            $query = "SELECT MAX(q.position) FROM quiz_parts q WHERE q.quiz_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->quiz_id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->totalParts = $row['MAX(q.position)'];
            return $this->totalParts;
        }
        
        public function addQuizPart() {
            $insertQuery = "INSERT INTO quiz_parts SET
                                type_id = :type_id,
                                quiz_id = :quiz_id,
                                part_title = :part_title,
                                duration = :duration,
                                position = :position";
            
            $stmt = $this->conn->prepare($insertQuery);
            
            // Bind parameters
            $stmt->bindParam(':type_id', $this->type_id);
            $stmt->bindParam(':quiz_id', $this->quiz_id);
            $stmt->bindParam(':part_title', $this->part_title);
            $stmt->bindParam(':position', $this->position);
            $stmt->bindParam(':duration', $this->duration);

            // Execute
            if ($stmt->execute()) {
                return true;
            } else {
                printf("Error %s". \n, $stmt->err);
                return false;
            }
        }
    }



