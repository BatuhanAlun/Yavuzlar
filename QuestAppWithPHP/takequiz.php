<?php
session_start();
include "functions/functions.php";

$user_id = $_SESSION["id"];
$username = $_SESSION["username"];
$isAdmin = $_SESSION["isAdmin"];


$current_question_index = isset($_POST['question_index']) ? (int)$_POST['question_index'] : 0;


if (!isset($_SESSION['questions'])) {
    $question_ids = getQuestid($user_id);
    $questions = getQuestByid($question_ids);
    shuffle($questions);
    $_SESSION['questions'] = $questions;
}


$is_correct = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['quiz_finished']) && $_POST['quiz_finished'] == '1') {

        $temp_user_id = $_SESSION["id"];
        $temp_username = $_SESSION["username"];
        $temp_isAdmin = $_SESSION["isAdmin"];
        
        session_unset();
        session_destroy();

        session_start();
        $_SESSION["id"] = $temp_user_id;
        $_SESSION["username"] = $temp_username;
        $_SESSION["isAdmin"] = $temp_isAdmin;


        header("Location: quests.php?searchinput=&diflvl=");
        exit();
    } else {
        $selected_answer = $_POST['answer'];

        if (isset($_SESSION['questions'][$current_question_index])) {
            $correct_answer = $_SESSION['questions'][$current_question_index]['correctanswer']; // Doğru cevap

            
            if ($selected_answer == $correct_answer) {
                $is_correct = true;
                increase_score($user_id);
            } else {
                $is_correct = false;
                decrease_score($user_id);
            }

           
            markQuestionAsSolved($user_id, $_SESSION['questions'][$current_question_index]['id']);
            unset($_SESSION['questions'][$current_question_index]);
            $_SESSION['questions'] = array_values($_SESSION['questions']);
        }


    }
}


$current_question = isset($_SESSION['questions'][$current_question_index]) ? $_SESSION['questions'][$current_question_index] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Take Quiz</title>
</head>
<body>
    <form method="post">
        <div class="main-div">
            <h2>Question:</h2>
            <?php if ($current_question): ?>
                <h3><?php echo htmlspecialchars($current_question['questname']); ?></h3>
                <button type="submit" class="edit-button" name="answer" value="selection1"><?php echo htmlspecialchars($current_question['selection1']); ?></button>
                <button type="submit" class="edit-button" name="answer" value="selection2"><?php echo htmlspecialchars($current_question['selection2']); ?></button>
                <button type="submit" class="edit-button" name="answer" value="selection3"><?php echo htmlspecialchars($current_question['selection3']); ?></button>
                <button type="submit" class="edit-button" name="answer" value="selection4"><?php echo htmlspecialchars($current_question['selection4']); ?></button>
                <input type="hidden" name="question_index" value="<?php echo $current_question_index; ?>">
            <?php else: ?>
                <p>No more questions!</p>
                <input type="hidden" name="quiz_finished" value="1">
                <button type="submit">Finish Quiz</button>
            <?php endif; ?>
        
    </form>

    <?php if (isset($is_correct)): ?>
        
            <?php if ($is_correct): ?>
                <p style="color: green;">Correct!</p>
            <?php elseif ($current_question): ?>
                <p style="color: red;">Incorrect! The correct answer was: <?php echo htmlspecialchars($current_question[$correct_answer]); ?></p>
            <?php endif; ?>
        </div>
        <?php if (!empty($_SESSION['questions'])): ?>
            <form method="post">
                <input type="hidden" name="question_index" value="<?php echo $current_question_index + 1; ?>">
            </form>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
