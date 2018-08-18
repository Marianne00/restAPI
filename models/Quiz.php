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
        public $kunware_session;
        public $description;
        
        //Quiz Part Properties
        public $type_id;
        public $type_name;
        public $part_title;
        public $position;
        public $totalParts;
        public $duration;
        
                
        //Question Properties
        public $question;
        public $question_id;
        public $answer_id;
        public $values = array();
        public $correct;
        public $order = 'a';


        //Quiz Update Variables
        public $new_part_title;
        public $new_type_id;
        public $part_id;
        
        //Question Choices Variables
         public $a;
         public $b;
         public $c;
         public $d;

        // Constructor
        public function __construct($db) {
            $this->conn = $db;
        }

        public function addQuiz() {
            $insertQuery = "INSERT INTO quizzes
                            SET
                              quiz_title = :quizTitle,
                              description = :description
                              ";

            $stmt = $this->conn->prepare($insertQuery);

            $this->quizTitle = htmlspecialchars(strip_tags($this->quizTitle));
            $this->description = htmlspecialchars(strip_tags($this->description));

            // Bind parameters
            $stmt->bindParam(':quizTitle', $this->quizTitle);
            $stmt->bindParam(':description', $this->description);
            
  
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
        
        //Read Quiz
        public function readQUiz() {
            //Create query
            $query = "SELECT 
            a.quiz_title,
            a.description,
            a.date_created, 
                (
                    SELECT CONCAT(fname,' ',mname,' ',lname) 
                    FROM admins
                    WHERE
                    admin_id = a.admin_id
                )as quizAdmin
            FROM 
            quizzes a 
            WHERE
            a.admin_id =".$_GET['admin_id']."
                ORDER BY
                    a.quiz_id ASC";
            
            //Prepare Statement
            $stmt = $this->conn->prepare($query);
              
            //Execute Query
            $stmt->execute();
            
            return $stmt;
        }
        //Read Questions
        public function readQuestions() {
            //Create query
        $query = " SELECT 
                    a.question,
                    (
                        SELECT value from answer_choices
                        WHERE a.answer = choice_id
                    )as rightAnswer,
                    (
                        SELECT 
                        value
                        from answer_choices  
                        WHERE
                        a.question_id = question_id
                        AND post = 'a' OR 'A'
                    )as choice1,
                     (
                        SELECT value 
                        from answer_choices  
                        WHERE
                        a.question_id = question_id
                        AND post = 'b' OR 'B'
                    )as choice2,
                     (
                        SELECT value 
                        from answer_choices  
                        WHERE
                        a.question_id = question_id
                        AND post = 'c' OR 'C'
                    )as choice3,
                     (
                        SELECT value 
                        from answer_choices  
                        WHERE
                        a.question_id = question_id
                        AND post = 'd' OR 'D'
                    )as choice4
                    FROM
                    questions a,
                    quizzes b
                    WHERE 
                    b.admin_id LIKE '%".$_GET['admin_id']."%'
                    AND
                    b.quiz_id LIKE '%".$_GET['quiz_id']."%'
                    AND
                    a.part_id LIKE '%".$_GET['part_id']."%'
                    ";
            
            //Prepare Statement
            $stmt = $this->conn->prepare($query);
              
            //Execute Query
            $stmt->execute();
            
            return $stmt;
        }
         public function selectTypeID() {
            //Create query
        $query = "SELECT 
                  a.type_id 
                  FROM 
                  quiz_parts a, 
                  questions b 
                  WHERE 
                  a.part_id = b.part_id ";
            //Prepare Statement
            $stmt = $this->conn->prepare($query);
              
            //Execute Query
            $stmt->execute();
            
            return $stmt;
        }
        public function readChoices() {
            //Create query
            $query = "SELECT 
            a.value
            FROM 
            answer_choices a left join  questions b
            on a.question_id = b.question_id";
           
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
            $insertQuery = 'UPDATE quizzes
                            SET
                              quiz_title = :quizTitle,
                              description = :description
                              WHERE
                              quiz_id = :quizID';

           // Prepare Insert Statement
           $stmt = $this->conn->prepare($insertQuery);

            // Clean inputted data
           $this->quizTitle = htmlspecialchars(strip_tags($this->quizTitle));
           $this->description = htmlspecialchars(strip_tags($this->description));
           $this->quizID = htmlspecialchars(strip_tags($this->quizID));

            // Bind parameters
            $stmt->bindParam(':quizTitle', $this->quizTitle);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':quizID', $this->quizID);

            // Execute
            if ($stmt->execute()) {
                return true;
            } else {
                printf("Error %s". \n, $stmt->err);
                return false;
            }
        }
        
        
          public function addQuestion() {
        $insertQuery = "INSERT INTO questions 
                        SET
                            quiz_id = :quiz_id,
                            part_id = :part_id,
                            question = :question";
        
        $stmt = $this->conn->prepare($insertQuery);
        $this->quizID = htmlspecialchars(strip_tags($this->quizID));
        $this->totalParts = htmlspecialchars(strip_tags($this->part_id));
        $this->duration = htmlspecialchars(strip_tags($this->question));    
        
        $stmt->bindParam(':quiz_id', $this->quizID);
        $stmt->bindParam(':part_id', $this->part_id);
        $stmt->bindParam(':question', $this->question);
        
        if($stmt->execute()){
            if($this->insertChoices()){
                return true;
            }
        }else{
            return false;
        }
        
    }
          public function addQuestionToTrueOrFalse() {    
        $insertQuery = "INSERT INTO questions 
                        SET
                            quiz_id = :quiz_id,
                            part_id = :part_id,
                            question = :question";
        
        $stmt = $this->conn->prepare($insertQuery);
        $this->quizID = htmlspecialchars(strip_tags($this->quizID));
        $this->totalParts = htmlspecialchars(strip_tags($this->part_id));
        $this->duration = htmlspecialchars(strip_tags($this->question));    
        
        $stmt->bindParam(':quiz_id', $this->quizID);
        $stmt->bindParam(':part_id', $this->part_id);
        $stmt->bindParam(':question', $this->question);
        
        if($stmt->execute()){
            if($this->insertToAnsweChoices()){
                return true;
            }
        }else{
            return false;
        }
        
    }

    public function insertChoices() {
        $counter = 0;
        $insertQuery = "INSERT INTO answer_choices
                        SET
                            question_id = (select max(question_id) from questions),
                            quiz_id = :quiz_id,
                            value = :value,
                            post = :order";
        
        $stmt = $this->conn->prepare($insertQuery);  
        
        foreach ($this->values as $val){
            
            $this->question_id = htmlspecialchars(strip_tags($this->question_id));
            $this->quizID = htmlspecialchars(strip_tags($this->quizID));
            $this->order = htmlspecialchars(strip_tags($this->order)); 
            $val = htmlspecialchars(strip_tags($val));
            $stmt->bindParam(':quiz_id', $this->quizID);
            $stmt->bindParam(':value', $val);
            $stmt->bindParam(':order', $this->order);
            
            if ($stmt->execute()){
                $counter++;
                $this->order++;
            }
        }
        
        if($counter==4){
            return true;
        }else{
            return false;
        }
        
        
    }
        public function insertToAnsweChoices() {
        $insertQuery = "INSERT INTO answer_choices
                        SET
                            question_id = (select max(question_id) from questions),
                            quiz_id = :quiz_id,
                            value = :value";
       
        $stmt = $this->conn->prepare($insertQuery);  
            
            $this->question_id = htmlspecialchars(strip_tags($this->question_id));
            $this->quizID = htmlspecialchars(strip_tags($this->quizID));
            $this->value = htmlspecialchars(strip_tags($this->correct));
            
            $stmt->bindParam(':quiz_id', $this->quizID);
            $stmt->bindParam(':value', $this->correct);
            
            if ($stmt->execute()){
            return true;
        }else{
            return false;
        }    
    }
        public function searchQuiz() {
            //Select query
            $query =  "SELECT
                        a.quiz_title, 
                       (
                       SELECT Count(quiz_id) FROM quiz_parts
                       Where quiz_id = a.quiz_id 
                       ) as partsperQuiz
                       FROM 
                       quizzes a
                            WHERE 
                                a.admin_id LIKE '%".$_GET['admin_id']."%'
                                AND
                                a.quiz_id LIKE '%".$_GET['quiz_id']."%'
                                AND
                                a.quiz_title LIKE '%".$_GET['quiz_title']."%'";
            
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
            $stmt->bindParam(':position', $this->totalParts);
            $stmt->bindParam(':duration', $this->duration);

            // Execute
            if ($stmt->execute()) {
                return true;
            } else {
                printf("Error %s". \n, $stmt->err);
                return false;
            }
        }

        public function updateQuizPart(){

            //NILAGAY KO NALANG NA WHERE IS YUNG PART_ID KASI UNIQUE NAMAN SYA
            $updateQuery = " UPDATE quiz_parts 
                             SET part_title= :new_part_title,
                                 type_id= :new_type_id 
                             WHERE part_id = :part_id";
            //PREPARE STATEMENT
            $stmt = $this->conn->prepare($updateQuery);
            //BINDING OF PARAMETERS
            $stmt->bindParam(':new_part_title', $this->new_part_title);
            $stmt->bindParam(':new_type_id', $this->new_type_id);
            $stmt->bindParam(':part_id', $this->part_id);

            //TESTING
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
        
        public function viewQuizList() {
            $query = 'SELECT * FROM quiz ORDER BY quizTitle ' . $_GET['order'];
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);
            
            // Execute Query
            $stmt->execute();
            
            return $stmt;
        }
        
        
        public function searchQuizPart() {
            //Select query
            $query = 
            "SELECT
            a.part_title,
            a.duration,
            b.type
           FROM 
           quizzes c,
            quiz_parts a left join question_types b 
            on a.type_id = b.type_id
                WHERE 
                  c.admin_id LIKE '%".$_GET['admin_id']."%'
                  AND
                  a.quiz_id LIKE '%".$_GET['quiz_id']."%'
                  AND
                  a.part_id LIKE '%".$_GET['part_id']."%'
                  AND
                  a.part_title LIKE '%".$_GET['part_title']."%'";
            
             //Prepare Statement   
            $stmt = $this->conn->prepare($query);
            
            //Execute Query
            $stmt->execute();
            
            return $stmt;
        }

        public function blankGuessWord($word){

            $numOfLoops = floor((strlen($word) * .5));
            $array= array();
            while ($numOfLoops > 0) {
                $found = 0;
                $randomLoc = rand(0,strlen($word)-1);  
                array_push($array, $randomLoc);
                for ($q=0; $q < count($array); $q++) { 
                    if($randomLoc == $array[$q]){
                        $found += 1;
                    }
                }
                if($found == 1 && $word[$randomLoc] != " "){
                    $word[$randomLoc] = "_";
                }else{
                    $numOfLoops++;
                }
                $numOfLoops--;
            }
            echo $word;
        }
        
        
        public function insertAnswer(){
        
            $query = "SELECT max(choice_id) from answer_choices WHERE value = '$this->correct'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt;
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $this->answer_id = $row['max(choice_id)'];
            }

            $query = "SELECT max(question_id) FROM questions";
             $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt;
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $this->question_id = $row['max(question_id)'];
            }

            $updateQuery = "UPDATE questions set answer = '$this->answer_id' WHERE question_id = $this->question_id";
            $stmt = $this->conn->prepare($updateQuery);

            if($stmt->execute()){
                return true;
            }else{
                return false;
            }  
    }
        
        public function insertAnswerforTrueorFalse(){
            $query = "SELECT max(choice_id) from answer_choices WHERE value = '$this->correct'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt;
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $this->answer_id = $row['max(choice_id)'];
            }
            $query = "SELECT max(question_id) FROM questions";
             $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt;
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $this->question_id = $row['max(question_id)'];
            }
            $updateQuery = "UPDATE questions set answer = '$this->answer_id' WHERE question_id = $this->question_id";
            $stmt = $this->conn->prepare($updateQuery);
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
        
    }
        
    }



