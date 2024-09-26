<?php

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


function registerUser($fname,$surname,$username,$passwd,$role){
    
    include "db.php";

    $hashedpass = password_hash($passwd, PASSWORD_ARGON2ID);

    $query = "INSERT INTO users (fname,surname,username,passwd,rolee) VALUES(:fname, :surname, :username, :passwd, :rolee)";

    $statement = $pdo->prepare($query);

    $statement->execute([
        ':fname' => $fname,
        ':surname' => $surname,
        ':username' => $username,
        ':passwd' => $hashedpass,
        ':rolee' => $role
    ]);

}

function registerCompany($fname, $surname, $username, $passwd,$role) {

    include "db.php";

    
    $hashedpass = password_hash($passwd, PASSWORD_ARGON2ID);

    $query = "INSERT INTO users (fname, surname, username, passwd, rolee) VALUES (:fname, :surname, :username, :passwd, :rolee)";

    $statement = $pdo->prepare($query);
    
    $statement->execute([
        ':fname' => $fname,
        ':surname' => $surname,
        ':username' => $username,
        ':passwd' => $hashedpass,
        ':rolee' => $role
    ]);

    $userId = $pdo->lastInsertId();

    $updateQuery = "UPDATE users SET company_id = :company_id WHERE id = :id";
    $updateStatement = $pdo->prepare($updateQuery);
    $updateStatement->execute([
        ':company_id' => $userId,
        ':id' => $userId
    ]);
    
    $querycomp = "INSERT INTO company (cname, company_id) VALUES (:cname, :company_id)";
    $statementcomp = $pdo->prepare($querycomp);
    $statementcomp->execute([
        ':cname' => $fname,
        ':company_id' => $userId,
    ]);
    
}

function updateCompid($userId){

    include "db.php";

    $updateQueryone = "INSERT INTO company (id) VALUES id = :id";
    $updateStatementone = $pdo->prepare($updateQueryone);
    $updateStatementone->execute([
        ':id' => $userId,
    ]);
}

function login($username, $passwd) {
    include "db.php";


    $query = "SELECT * FROM users WHERE username = :username";
    $statement = $pdo->prepare($query);
    $statement->execute(['username' => $username]);


    $result = $statement->fetch(PDO::FETCH_ASSOC);


    if ($result && password_verify($passwd, $result['passwd'])) {
       
        if ($result['deleted'] == 1) {
            return false;
        }
        
        return $result;
    } else {
        return false;
    }
}



function updateUser($username,$fname,$surname,$user_id,$dest_path){

    include "db.php";

    $query = "UPDATE users SET username = '$username',fname = '$fname',surname = '$surname', pp_path = '$dest_path' WHERE id = '$user_id'";

    $statement = $pdo->prepare($query);

    $statement->execute();

}

function updateCompany($username,$fname,$surname,$user_id,$dest_path){

    include "db.php";

    $query = "UPDATE users SET username = '$username',fname = '$fname',surname = '$surname'  pp_path = '$dest_path' WHERE id = '$user_id'";

    $statement = $pdo->prepare($query);

    $statement->execute();

    $queryone = "UPDATE company SET cname = '$username' WHERE company_id = '$user_id'";

    $statementone = $pdo->prepare($queryone);

    $statementone->execute();
    
}

function addRestaurant($restaurant_name,$res_des,$dest_path,$user_id) {

    include "db.php";

    $query = "INSERT INTO restoran (company_id, res_des, logo_path, res_name) VALUES (:company_id, :res_des, :logo_path, :res_name)";

    $statement = $pdo->prepare($query);

    $statement->execute([
        ':company_id' => $user_id,
        ':res_des' => $res_des,
        ':logo_path' => $dest_path,
        ':res_name' => $restaurant_name
    ]);

    $res_id = $pdo->lastInsertId();
    return $res_id;
}

function addMeal($meal_names,$meal_prices,$meal_des,$res_id,$user_id){

    include "db.php";

    foreach ($meal_names as $index => $meal_name) {
        $meal_price = $meal_prices[$index];
        $meal_deses = $meal_des[$index];
        

        
        $query = "INSERT INTO meals (company_id, meal_name, meal_des, meal_price, res_id) VALUES (:company_id, :meal_name, :meal_des, :meal_price, :res_id)";
        
        
        $statement = $pdo->prepare($query);
        
    
        $statement->execute([
            ':company_id' => $user_id,
            ':meal_name' => $meal_name,
            ':meal_des' => $meal_deses,
            ':meal_price' => $meal_price,
            ':res_id' => $res_id
        ]);

                
                $meal_id = $pdo->lastInsertId();
        
            
                $meal_ids[] = $meal_id;

    }

    return $meal_ids;
}

function getResData($user_id){

    include "db.php";

    $query = "SELECT * FROM restoran WHERE company_id = :company_id";
    
    $statement = $pdo->prepare($query);

    $statement->execute(['company_id' => $user_id]);

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $result;


}

function getMealData($user_id){

    include "db.php";

    $query = "SELECT * FROM meals WHERE company_id = :company_id";
    
    $statement = $pdo->prepare($query);

    $statement->execute(['company_id' => $user_id]);

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $result;

    
}

function editRestaurant($restaurant_name,$res_des,$dest_path,$user_id){
    include "db.php";

    if(is_array($restaurant_name)){

        foreach ($restaurant_name as $index => $restaurant_names) {
            $res_deses = $res_des[$index];
            $dest_pathes = $dest_path[$index];
    
            
            $query = "UPDATE restoran SET res_name = '$restaurant_names',res_des = '$res_deses',logo_path = '$dest_pathes' WHERE company_id = '$user_id'";
            
            
            $statement = $pdo->prepare($query);
            
            echo "editres1";
            $statement->execute();
        }



    } else{

        $query = "UPDATE restoran SET res_name = '$restaurant_name',res_des = '$res_des',logo_path = '$dest_path' WHERE company_id = '$user_id'";
            
            
        $statement = $pdo->prepare($query);
        
        echo "editres2";
        $statement->execute();

    }



}

function editMeal($meal_names,$meal_prices,$meal_des,$user_id){

    include "db.php";

    if(is_array($meal_names)){

        foreach ($meal_names as $index => $meal_name) {
            $meal_deses = $meal_des[$index];
            $meal_price = $meal_prices[$index];
    
            
            $query = "UPDATE meals SET meal_name = '$meal_name',meal_des = '$meal_deses',meal_price = '$meal_price' WHERE company_id = '$user_id'";
            
            
            $statement = $pdo->prepare($query);
            
            echo "editmeal1";
            $statement->execute();
        }

    } else{

        $query = "UPDATE meals SET meal_name = '$meal_names',meal_des = '$meal_des',meal_price = '$meal_prices' WHERE company_id = '$user_id'";
            
            
        $statement = $pdo->prepare($query);
        
        echo "editmeal2";
        $statement->execute();

    }


}

function editRestaurantOutDest($restaurant_name,$res_des,$user_id){

    include "db.php";

    if(is_array($restaurant_name)){

        foreach ($restaurant_name as $index => $restaurant_names) {
            $res_deses = $res_des[$index];
            
            
            $query = "UPDATE restoran SET res_name = '$restaurant_names',res_des = '$res_deses' WHERE company_id = '$user_id'";
            
            
            $statement = $pdo->prepare($query);
            
            echo "editres3";
            $statement->execute();
        }



    }else {
        $query = "UPDATE restoran SET res_name = '$restaurant_name',res_des = '$res_des' WHERE company_id = '$user_id'";

        $statement = $pdo->prepare($query);
        echo "editres4";
        $statement->execute();
    }



}

function getResNum($user_id){

    include "db.php";

   $query = " SELECT COUNT(*) FROM restoran WHERE company_id = :company_id;";

   $statement = $pdo->prepare($query);

   $statement->execute(['company_id' => $user_id]);

   $rowCount = $statement->fetchColumn();
   
   return $rowCount;
}

function updateResName($restaurant_id,$new_name) {

    include "db.php";

    $query = "UPDATE restoran SET res_name = '$new_name' WHERE id = '$restaurant_id'";

    $statement = $pdo->prepare($query);
    
    $statement->execute();
}

function updateResDes($restaurant_id,$new_des){
    include "db.php";

    $query = "UPDATE restoran SET res_des = '$new_des' WHERE id = '$restaurant_id'";

    $statement = $pdo->prepare($query);
    
    $statement->execute();
}


function updateMealName($restaurant_id,$new_meal_name){
    include "db.php";

    $query = "UPDATE meals SET meal_name = '$new_meal_name' WHERE id = '$restaurant_id'";

    $statement = $pdo->prepare($query);
    
    $statement->execute();
}


function updateMealPrice($restaurant_id,$new_meal_prices){
    include "db.php";

    $query = "UPDATE meals SET meal_price = '$new_meal_prices' WHERE id = '$restaurant_id'";

    $statement = $pdo->prepare($query);
    
    $statement->execute();
}


function updateMealDes($restaurant_id,$new_meal_des){
    include "db.php";

    $query = "UPDATE meals SET meal_des = '$new_meal_des' WHERE id = '$restaurant_id'";

    $statement = $pdo->prepare($query);
    
    $statement->execute();
}

function updateResLogo($restaurant_id,$dest_path) {

    include "db.php";

    $query = "UPDATE restoran SET logo_path = '$dest_path' WHERE id = '$restaurant_id'";

    $statement = $pdo->prepare($query);
    
    $statement->execute();


}


function delRes($res_id){

    include "db.php";

    $query = "DELETE FROM restoran WHERE id = '$res_id'";

    $statement = $pdo->prepare($query);
    
    $statement->execute();


    $queryone = "DELETE FROM meals WHERE res_id ='$res_id'";

    $statementone = $pdo->prepare($queryone);
    
    $statementone->execute();


}

function delMeal($meal_id){

    include "db.php";

    $queryone = "DELETE FROM meals WHERE id ='$meal_id'";

    $statementone = $pdo->prepare($queryone);
    
    $statementone->execute();


}

function addMealwithLogo($meal_names,$meal_prices,$meal_des,$restaurant_id,$user_id,$dest_path){

    include "db.php";

        
        $query = "INSERT INTO meals (company_id, meal_name, meal_des, meal_price, res_id, meal_logo) VALUES (:company_id, :meal_name, :meal_des, :meal_price, :res_id, :meal_logo)";
        
        $statement = $pdo->prepare($query);
        
        $statement->execute([
            ':company_id' => $user_id,
            ':meal_name' => $meal_names,
            ':meal_des' => $meal_des,
            ':meal_price' => $meal_prices,
            ':res_id' => $restaurant_id,
            ':meal_logo' => $dest_path
        ]);
 


}

function updateMealLogo($meal_id,$dest_pathone){

    include "db.php";

    $query = "UPDATE meals SET meal_logo = '$dest_pathone' WHERE id = '$meal_id'";

    $statement = $pdo->prepare($query);
    
    $statement->execute();

}

function addMealPhoto($meal_id,$dest_patho){

    include "db.php";

    $query = "UPDATE meals SET meal_logo = '$dest_patho' WHERE id = '$meal_id'";

    $statement = $pdo->prepare($query);
    
    $statement->execute();
}

function getAllRes(){

    include "db.php";

    $query = "SELECT * FROM restoran";

    $statement = $pdo->prepare($query);

    $statement->execute();

    $result = $statement->fetchAll();

    return $result;

}

function getMealBy_id($res_id) {
    include "db.php";

    $query = "SELECT * FROM meals WHERE res_id = :res_id";

    $statement = $pdo->prepare($query);

    $statement->execute(['res_id' => $res_id]);

    $result = $statement->fetchAll();

    return $result;


}

function getMealBasket($user_id) {
    include "db.php";

    
    $query = "SELECT meal_id, SUM(quantity) as quantity FROM basket WHERE user_id = :user_id GROUP BY meal_id";
    $statement = $pdo->prepare($query);
    $statement->execute(['user_id' => $user_id]);

    $basketItems = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (empty($basketItems)) {
        return [];
    }

    
    $meal_ids = array_column($basketItems, 'meal_id');

    
    $placeholders = implode(',', array_fill(0, count($meal_ids), '?'));

    
    $query = "SELECT id, res_id, company_id, meal_des, meal_price, meal_name, meal_logo 
              FROM meals 
              WHERE id IN ($placeholders)";
    $statement = $pdo->prepare($query);
    $statement->execute($meal_ids);

    $meals = $statement->fetchAll(PDO::FETCH_ASSOC);

    
    foreach ($meals as &$meal) {
        foreach ($basketItems as $basketItem) {
            if ($meal['id'] == $basketItem['meal_id']) {
                $meal['quantity'] = $basketItem['quantity'];
            }
        }
    }

    return $meals;
}





function addMealtoBasket($user_id, $meal_id) {
    include "db.php";

    $query = "SELECT id, quantity FROM basket WHERE user_id = :user_id AND meal_id = :meal_id";
    $statement = $pdo->prepare($query);
    $statement->execute([
        ':user_id' => $user_id,
        ':meal_id' => $meal_id,
    ]);

    $existingItem = $statement->fetch(PDO::FETCH_ASSOC);

    if ($existingItem) {
        $new_quantity = $existingItem['quantity'] + 1;
        $updateQuery = "UPDATE basket SET quantity = :quantity WHERE id = :id";
        $updateStatement = $pdo->prepare($updateQuery);
        $updateStatement->execute([
            ':quantity' => $new_quantity,
            ':id' => $existingItem['id'],
        ]);
    } else {
        $insertQuery = "INSERT INTO basket (user_id, meal_id, quantity) VALUES (:user_id, :meal_id, 1)";
        $insertStatement = $pdo->prepare($insertQuery);
        $insertStatement->execute([
            ':user_id' => $user_id,
            ':meal_id' => $meal_id,
        ]);
    }
}

function getCoupon($user_id){

    include "db.php";

    $query = "SELECT * FROM onetime_coupon LEFT JOIN used_coupon ON onetime_coupon.id = used_coupon.used_coupon_id AND used_coupon.user_id = :user_id WHERE used_coupon.user_id IS NULL; ";

    $statement = $pdo->prepare($query);
    
    $statement->execute([':user_id' => $user_id]);

    $results = $statement->fetchAll();

    return $results;
}

function markCoupon($user_id,$c_id){
    include "db.php";

    $query = "INSERT INTO used_coupon (user_id, used_coupon_id) VALUES (:user_id, :c_id)";
        
    $statement = $pdo->prepare($query);
    
    $statement->execute([
        ':user_id' => $user_id,
        ':c_id' => $c_id,
    ]);

}

function updateBalance($user_id,$balance) { 

    include "db.php";

    $query = "UPDATE users SET balance = :balance WHERE id = :id";

    $statement = $pdo->prepare($query);

    $statement->execute([
        ':balance' => $balance,
        ':id' => $user_id
    ]);


}

function openOrder($user_id, $total_price, $notes) {

    $order_id = insertOrder($user_id, $total_price, $notes);


    $meals = getMealBasket($user_id);
    foreach ($meals as $meal) {
        insertOrderItem($order_id, $meal['id'], $meal['quantity'], $meal['meal_price']);
    }

    return $order_id;
}

function insertOrder($user_id, $total_price, $notes) {
    
    include "db.php";

    $query = "INSERT INTO orders (user_id, total_price, notes) VALUES (:user_id, :total_price, :notes)";

    $statement = $pdo->prepare($query);

    $statement->execute([':user_id' => $user_id, ':total_price' => $total_price, ':notes' => $notes]);
    
    return $pdo->lastInsertId();
}

function insertOrderItem($order_id, $meal_id, $quantity, $price) {
    include "db.php";

    $res_id = getResidForOrder($meal_id);

    $query = "INSERT INTO order_items (order_id, meal_id, quantity, price,res_id) VALUES (:order_id, :meal_id, :quantity, :price, :res_id)";

    $statement = $pdo->prepare($query);

    $statement->execute([':order_id' => $order_id, ':meal_id' => $meal_id, ':quantity' => $quantity, ':price' => $price, ':res_id' => $res_id]);

}

function clearBasket($user_id){
    include "db.php";

    $query = "DELETE FROM basket WHERE user_id = :user_id;";

    $statement = $pdo->prepare($query);

    $statement->execute([':user_id' => $user_id]);


}

function getResidForOrder($meal_id){
    include "db.php";

    $query = "SELECT res_id FROM meals WHERE id = :meal_id";

    $statement = $pdo->prepare($query);

    $statement->execute([':meal_id' => $meal_id]);

    $res_id = $statement->fetchColumn();

    return $res_id;
}

function getResComp($company_id){

    include "db.php";

    $query = "SELECT id FROM restoran WHERE company_id = :company_id";

    $statement = $pdo->prepare($query);

    $statement->execute([':company_id' => $company_id]);
    
    $res_ids = $statement->fetchAll();

    return $res_ids;
}

function getAllOpenPendingOrders() {
    include "db.php";
    
    $query = "
        SELECT o.id AS order_id, o.user_id, o.total_price, o.notes, o.status, oi.meal_id, oi.quantity, m.meal_name, m.meal_price, oi.res_id
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        JOIN meals m ON oi.meal_id = m.id
        WHERE o.status = 'pending' OR o.status = 'processing'
    ";
    
    $statement = $pdo->prepare($query);
    $statement->execute();
    
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
function getAllClosedOrders() {
    include "db.php";
    
    $query = "
        SELECT o.id AS order_id, o.user_id, o.total_price, o.notes, o.status, oi.meal_id, oi.quantity, m.meal_name, m.meal_price, oi.res_id
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        JOIN meals m ON oi.meal_id = m.id
        WHERE o.status = 'completed' OR o.status = 'canceled'
    ";
    
    $statement = $pdo->prepare($query);
    $statement->execute();
    
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}


function filterOrdersByResIds($allPendingOrders, $res_ids) {
    $filteredOrders = [];


    for ($i = 0; $i < count($res_ids); $i++) {

        for ($j = 0; $j < count($allPendingOrders); $j++) {

            if ($res_ids[$i]['id'] == $allPendingOrders[$j]['res_id']) {

                $filteredOrders[] = $allPendingOrders[$j];

            }
        }
    }

    return $filteredOrders;
}

function updateOrderStatus($order_id, $new_status) {
    include "db.php";

    $query = "UPDATE orders SET status = :status WHERE id = :id";
    $statement = $pdo->prepare($query);

    return $statement->execute([':status' => $new_status,':id' => $order_id]);
}

function getAllOrdersForUser($user_id) {
    include "db.php";

    $query = "SELECT id, order_date, total_price, status, notes FROM orders WHERE user_id = :user_id";
    
    $statement = $pdo->prepare($query);

    $statement->execute([':user_id' => $user_id]);

    $orders = $statement->fetchAll();


    return $orders;
}

function addComment($user_id,$username,$res_id,$rating,$comment){
    include "db.php";

    $query = "INSERT INTO comments (user_id, res_id, username, comment, score) VALUES (:user_id, :res_id, :username, :comment, :score)";

    $statement = $pdo->prepare($query);

    $statement->execute([':user_id' => $user_id, ':res_id' => $res_id, ':username' => $username,':comment' => $comment,':score' => $rating]);



}

function getCommentBy_id($res_id){
    include "db.php";

    $query = "SELECT * FROM comments WHERE res_id = :res_id";
    
    $statement = $pdo->prepare($query);

    $statement->execute(['res_id' => $res_id]);

    $result = $statement->fetchAll();

    return $result;

}

function getAverageScore($res_id) {
    include "db.php";

    $query = "SELECT AVG(score) as average_score FROM comments WHERE res_id = :res_id";

    $statement = $pdo->prepare($query);

    $statement->execute(['res_id' => $res_id]);

    $result = $statement->fetch(PDO::FETCH_ASSOC);

    return isset($result['average_score']) ? round($result['average_score'], 0) : 0;
}


function searchRes($searchinput) {
    include "db.php";

    // $query = "SELECT * FROM questions WHERE questname LIKE :searchinput";

    $searchinput = trim($searchinput);
    $searchinput = "%$searchinput%";



        $query = "SELECT * FROM restoran WHERE res_name LIKE :searchinput";
        $statement = $pdo->prepare($query);
        $statement->execute(['searchinput' => $searchinput]);


    $result = $statement->fetchAll();
    
    return $result;

}


function filterRestaurants($min_stars) {
    include "db.php";
    
    $statement = $pdo->prepare("
        SELECT r.* 
        FROM restoran r
        JOIN (SELECT res_id, AVG(score) as avg_score FROM comments GROUP BY res_id) AS avg_scores 
        ON r.id = avg_scores.res_id 
        WHERE avg_scores.avg_score >= :min_stars
    ");
    $statement->execute(['min_stars' => $min_stars]);
    
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function searchMeal($searchinput,$res_id) {
    include "db.php";


    $searchinput = trim($searchinput);
    $searchinput = "%$searchinput%";

    $query = "SELECT * FROM meals WHERE meal_name LIKE :searchinput AND res_id = :res_id";

    $statement = $pdo->prepare($query);

    $statement->execute(['searchinput' => $searchinput,':res_id' => $res_id]);

    $result = $statement->fetchAll();

    return $result;


}

function updateMealDiscount($restaurant_id,$new_meal_discount){
    include "db.php";

    $query = "UPDATE meals SET meal_discount = '$new_meal_discount' WHERE id = '$restaurant_id'";

    $statement = $pdo->prepare($query);
    
    $statement->execute();
}

function getCustomers(){
    include "db.php";

    $query = "SELECT * FROM users WHERE rolee = 'user'";

    $statement = $pdo->prepare($query);
    
    $statement->execute();

    $result = $statement->fetchAll();

    return $result;

}

function getAllPendingOrdersForUser($user_id) {
    include "db.php";

    $query = "SELECT id, order_date, total_price, status, notes FROM orders WHERE user_id = :user_id AND orders.status = 'pending' OR orders.status = 'processing' ";
    
    $statement = $pdo->prepare($query);

    $statement->execute([':user_id' => $user_id]);

    $orders = $statement->fetchAll();


    return $orders;
}


function bancustomer($user_id){
    include "db.php";

    $query = "UPDATE users SET deleted = '1', deleted_at = NOW() WHERE id = '$user_id'";

    $statement = $pdo->prepare($query);

    $statement->execute();

}


function getCompanies(){
    include "db.php";

    $query = "SELECT * FROM users WHERE rolee = 'company'";

    $statement = $pdo->prepare($query);
    
    $statement->execute();

    $result = $statement->fetchAll();

    return $result;

}


function addCoupon($coupon_name,$percentage){
    include "db.php";

    $query = "INSERT INTO onetime_coupon (c_name,percentage) VALUES(:cname, :percentage)";

    $statement = $pdo->prepare($query);

    $statement->execute([
        ':cname' => $coupon_name,
        ':percentage' => $percentage

    ]);
}

function getCoupons(){
    include "db.php";

    $query = "SELECT * FROM onetime_coupon";

    $statement = $pdo->prepare($query);
    
    $statement->execute();

    $result = $statement->fetchAll();

    return $result;

}

function deleteCoupon($coupon_id){
    include "db.php";

    $query = "DELETE FROM onetime_coupon WHERE id = '$coupon_id'";


    $statement = $pdo->prepare($query);

    $statement->execute();

}

function searchcustomer($searchinput) {
    include "db.php";

    // $query = "SELECT * FROM questions WHERE questname LIKE :searchinput";

    $searchinput = trim($searchinput);
    $searchinput = "%$searchinput%";



        $query = "SELECT * FROM users WHERE username LIKE :searchinput AND rolee = 'user'";
        $statement = $pdo->prepare($query);
        $statement->execute(['searchinput' => $searchinput]);


    $result = $statement->fetchAll();
    
    return $result;

}
function searchcompanies($searchinput) {
    include "db.php";

    // $query = "SELECT * FROM questions WHERE questname LIKE :searchinput";

    $searchinput = trim($searchinput);
    $searchinput = "%$searchinput%";



        $query = "SELECT * FROM users WHERE username LIKE :searchinput AND rolee = 'company'";
        $statement = $pdo->prepare($query);
        $statement->execute(['searchinput' => $searchinput]);


    $result = $statement->fetchAll();
    
    return $result;

}
function filtercustomer($searchinput) {
    include "db.php";

    // $query = "SELECT * FROM questions WHERE questname LIKE :searchinput";

        $query = "SELECT * FROM users WHERE deleted = :searchinput AND rolee = 'user'";
        $statement = $pdo->prepare($query);
        $statement->execute(['searchinput' => $searchinput]);


    $result = $statement->fetchAll();
    
    return $result;

}

function updateCompanyname($username,$user_id){
    echo "yes";
    include "db.php";
    
    $query = "UPDATE users SET username = '$username' WHERE id = '$user_id'";

    $statement = $pdo->prepare($query);

    $statement->execute();

    
}
function addbalance($balance,$balance_user_id){
    include "db.php";
    
    $query = "UPDATE users SET balance = balance + '$balance' WHERE id = '$balance_user_id'";

    $statement = $pdo->prepare($query);

    $statement->execute();
}


?>
