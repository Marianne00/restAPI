# restAPI

TASKS FOR WEEK 3

Responsible: Allen, Marianne, Chris, Troyo, Rose ann

admins
	-register  
        (check inputs, validate, confirm password must match the password, username must be unique, password must be atleast 8characters)
        -fields: fname, mname, lname, username, password
	-login
        (check inputs, grant access when username and password is correct)
        -fields: username, password
    -forget password
        -di ko pa sure ano cool na way 
        
students
	-view all students chronologically, descending, top students, students with lowest scores
        -search by name, student number
        -view stats (score percentage, view scores in all quizzes, view answer history, view feedbacks per quiz)
    -add students manually
        -fields: stud_id, fname, mname, lname, automatic: date registered and status: inactive
	-add through csv
        -sino matapang na aako netong leche na to
	-set student status
        -active, inactive, drop, shits like that
        
        
note: kung matatapos mabuild yang back-end before matapos yung week. pwede na gawan ni allen at gian ng front end.

TASKS FOR WEEK 4

Responsible: Programmers

quiz
    -add quiz
        quiz_title
    -edit quiz 
        quiz_title
    -add quiz parts
        maximum of 4, part title, select question type, position
    -add question per each part
        -add question
        -add choices
        -edit question
        -edit choices
        -edit answer
        
        