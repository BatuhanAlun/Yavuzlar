<?php
session_start();
$id = $_GET['id'];
$is_admin = $_SESSION["isAdmin"];
if ($is_admin == 0){
    header("Location:index.php?message=You Dont Have Permission");
}


// if (isset($_POST['updatebtn'])){
   
//     header("Location:editQuery.php?id=$id");
//     $id = $_GET['id'];
//     exit();
// }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Soru Düzenle</title>
</head>
<body>
    <div class="main-div">
        <h1>Soru Düzenleme Paneli</h1>
        <div class="questpanel">
        <form action="editQuery.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
            <h2 id="question">Soruyu Düzenleyin</h2>
            <input type="text" class="quest1" id="questname" name="questname" placeholder="Soruyu Giriniz..." style="color: black;">
            <div class="answers" id="answers">
                <input type="text" id="selection1" name="selection1" placeholder="Şık 1" style="color: black;">
                <input type="text" id="selection2" name="selection2" placeholder="Şık 2" style="color: black;">
                <input type="text" id="selection3" name="selection3" placeholder="Şık 3" style="color: black;">
                <input type="text" id="selection4" name="selection4" placeholder="Şık 4" style="color: black;">
            </div>
            <div class="addquestdiv">
            <button class="addquestdivbtn" id="updatequestion" name="updatebtn" id="updatebtn">Güncelle</button>
            </div>
            </form>
        </div>
    </div>
    </script>
</body>
</html>
