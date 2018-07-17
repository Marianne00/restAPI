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
        public $kunware_session;
        public $type_id;
        public $type_name;
        public $part_title;
        public $position;

        // Constructor
        public function __construct($db) {
            $this->conn = $db;
        }

        public function addQuiz() {
            $insertQuery = "INSERT INTO quizzes
                            SET
                              quiz_title = :quiz_title
                              ";

            // Prepare Insert Statement
            $stmt = $this->conn->prepare($insertQuery);

            // Clean inputted data
            $this->quizTitle = htmlspecialchars(strip_tags($this->quizTitle));
            $this->parts = htmlspecialchars(strip_tags($this->parts));

            // Bind parameters
            $stmt->bindParam(':quiz_title', $this->quizTitle);

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
            $query = "SELECT MAX(quiz_id) FROM quizzes";

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Execute Query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->quizID = $row['MAX(quiz_id)'];

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

        
        public function getTypeID() {
            $query = "SELECT type_id FROM question_types 
                      WHERE
                        type = ?";
            
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(1, $this->type_name);
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->type_id = $row['type_id'];
        }

        public function getQuizID() {
            $query = "SELECT quiz_id FROM quizzes 
                      WHERE
                        quiz_title = ?";
            
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(1, $this->quizTitle);
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->$quizID = $row['quiz_id'];
        }
        
        
        public function addQuizPart() {
            $insertQuery = "INSERT INTO quiz_parts
                            SET
                                type_id = :type_id,
                                quiz_id = :quiz_id,
                                part_title = :part_title,
                                position = :position";
            
            $stmt = $this->conn->prepare($insertQuery);
            
            
        }

    }
