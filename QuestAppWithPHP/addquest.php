<?php
session_start();
$is_admin = $_SESSION["isAdmin"];
if ($is_admin == 0){
    header("Location:index.php?message=You Dont Have Permission");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Soru Ekleme Paneli</title>

</head>
<body>
    <div class="main-div">
        <h1>Soru Ekleme Paneli</h1>
        <div class="questpanel">
        <form action="addquestQuery.php" method="post" enctype="multipart/form-data">
            <h2 id="question">Soruyu Girin</h2>
            <input type="text" class="quest1" id="questname" name="questname" placeholder="Soruyu Giriniz..." style="color: black;">
            <div class="answers" id="answers">
                <input type="text" id="selection1" name="selection1" placeholder="Şık 1" style="color: black;">
                <input type="text" id="selection2" name="selection2" placeholder="Şık 2" style="color: black;">
                <input type="text" id="selection3" name="selection3" placeholder="Şık 3" style="color: black;">
                <input type="text" id="selection4" name="selection4" placeholder="Şık 4" style="color: black;">
            
            </div>
            <div class="correct-answer">

                <label for="correct-answer">Doğru Şık:</label>
                <select id="correct-answer" name="correctanswer" id="correctanswer">
                    <option value="selection1">1</option>
                    <option value="selection2">2</option>
                    <option value="selection3">3</option>
                    <option value="selection4">4</option>
                </select>
                
            </div>
            <div class="difficulty">
                
                <label for="difficulty">Zorluk Seviyesi:</label>
                <input type="range" id="difficulty" min="0" max="2" step="1" class="difficulty-slider" name="diflvl" id="diflvl">
                <div class="difficulty-labels">
                    <span>Kolay</span>
                    <span>Orta</span>
                    <span>Zor</span>
                
                </div>
            </div>
            <div class="addquestdiv">
                <button type="submit" class="addquestdivbtn" id="addquestion">Soru Ekle</button>
            </div>
        </form>
        </div>
    </div>
</body>
</html>
