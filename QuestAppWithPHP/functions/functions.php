<?php

function registerUser($username, $passwd, $isAdmin) {

    include "db.php";

    $query = "INSERT INTO users (username,passwd,isAdmin) VALUES('$username','$passwd','$isAdmin')";

    $statement = $pdo->prepare($query);

    $statement->execute();
}

function htmlclean($text){
    $text = preg_replace("'<script[^>]*>.*?</script>'si", '', $text );
    $text = preg_replace('/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is', '\2 (\1)', $text );
    $text = preg_replace('/<!--.+?-->/', '', $text ); 
    $text = preg_replace('/{.+?}/', '', $text ); 
    $text = preg_replace('/&nbsp;/', ' ', $text );
    $text = preg_replace('/&amp;/', ' ', $text ); 
    $text = preg_replace('/&quot;/', ' ', $text );
    $text = strip_tags($text);
    $text = htmlspecialchars($text); 

    return $text;
}

function login($username, $passwd) {
    include "db.php";

    $query = "SELECT *,COUNT(*) as count FROM users WHERE username = :username AND passwd =:passwd";

    $statement = $pdo->prepare($query);

    $statement->execute(['username' => $username, 'passwd' => $passwd]);

    $result = $statement->fetch();

    return $result;


}


function registerQuestion($questname,$selection1,$selection2,$selection3,$selection4,$correctanswer,$diflvl) {

    include "db.php";

    $query = "INSERT INTO questions (questname,selection1,selection2,selection3,selection4,correctanswer,diflvl) VALUES('$questname','$selection1','$selection2','$selection3','$selection4','$correctanswer','$diflvl')";

    $statement = $pdo->prepare($query);

    $statement->execute();

}


function getQuestions(){
    include "db.php";

    $query = "SELECT * FROM questions";

    $statement = $pdo->prepare($query);

    $statement->execute();

    $result = $statement->fetchAll();

    return $result;
}

function deleteQuestion($questionid) {
    include "db.php";

    $query = "DELETE FROM questions WHERE id= $questionid";

    $statement = $pdo->prepare($query);

    $statement->execute();
}

function editQuestion($questname,$selection1,$selection2,$selection3,$selection4,$questionid){
    include "db.php";

    $query = "UPDATE questions SET questname = '$questname',selection1 = '$selection1',selection2 = '$selection2',selection3 = '$selection3',selection4 = '$selection4' WHERE id = '$questionid'";

    $statement = $pdo->prepare($query);

    $statement->execute();
}

function searchQuest($searchinput,$diflvl) {
    include "db.php";

    // $query = "SELECT * FROM questions WHERE questname LIKE :searchinput";

    $searchinput = trim($searchinput);
    $searchinput = "%$searchinput%";

    if(empty(trim($searchinput))) {
        $query = "SELECT * FROM questions WHERE diflvl = :diflvl";
        $statement = $pdo->prepare($query);
        $statement->execute(['diflvl' => $diflvl]);

    }else if ($diflvl !== ''){

        $query = "SELECT * FROM questions WHERE questname LIKE :searchinput AND diflvl = :diflvl";
        $statement = $pdo->prepare($query);
        $statement->execute(['searchinput' => $searchinput,'diflvl' => $diflvl]);
    }else {

        $query = "SELECT * FROM questions WHERE questname LIKE :searchinput";
        $statement = $pdo->prepare($query);
        $statement->execute(['searchinput' => $searchinput]);
    }



    $result = $statement->fetchAll();
    
    return $result;

}

function getQuestid($user_id){
    include "db.php";

    
    $query = "SELECT questions.id 
              FROM questions 
              LEFT JOIN solved_questions 
              ON questions.id = solved_questions.questionid 
              AND solved_questions.userid = :user_id 
              WHERE solved_questions.questionid IS NULL";
    
    $statement = $pdo->prepare($query);
    $statement->execute(['user_id' => $user_id]);

    $result = $statement->fetchAll(PDO::FETCH_COLUMN, 0);

    return $result;
}


function getQuestByid($question_ids) {
    include "db.php"; 

    if (empty($question_ids)) {
        return []; 
    }


    $question_ids = array_map('intval', $question_ids);
    $placeholders = implode(',', $question_ids);


    $query = "SELECT * FROM questions WHERE id IN ($placeholders)";
    $statement = $pdo->prepare($query);

    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function markQuestionAsSolved($user_id, $question_id) {
    include "db.php";

    $query = "INSERT INTO solved_questions (userid, questionid) VALUES (:user_id, :question_id)";
    
    $statement = $pdo->prepare($query);
    $statement->execute(['user_id' => $user_id, 'question_id' => $question_id]);
}

function increase_score($user_id){
    include "db.php";

    $query = "UPDATE users SET score = score + 5 WHERE id = :user_id";

    $statement = $pdo->prepare($query);

    $statement->execute(['user_id' => $user_id]);
}

function decrease_score($user_id){
    include "db.php";

    $query = "UPDATE users SET score = score - 1 WHERE id = :user_id";

    $statement = $pdo->prepare($query);

    $statement->execute(['user_id' => $user_id]);
}

function getScore(){
    include "db.php";

    $query = "SELECT * FROM users ORDER BY score DESC";

    $statement = $pdo->prepare($query);

    $statement->execute();

    $result = $statement->fetchAll();

    return $result;
}




















?>