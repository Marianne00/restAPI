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
        public $kunware_session = 69;

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

    }
