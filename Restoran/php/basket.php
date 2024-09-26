<?php

session_start();
include "functions/functions.php";


$user_id = $_SESSION['id'];
$balance = $_SESSION['balance'];


$meals = getMealBasket($user_id);
$coupons = getCoupon($user_id);
$total_price = 0;


foreach ($meals as $meal) {
    $total_price += $meal['meal_price'] * $meal['quantity'];
    $first_price = $total_price;
}


if (isset($_POST['use_coupon']) && isset($_POST['coupon'])) {
    $coupon = $_POST['coupon'];
    $coupon_found = false;

    if (in_array($coupon, array_column($coupons, 'c_name'))) {
        foreach ($coupons as $cop) {
            if ($cop['c_name'] == $coupon) {
                $c_id = $cop['c_id'];
                $c_percentage = $cop['percentage'];
                $coupon_found = true;
                break;
            }
        }

        if ($coupon_found) {
            $discount_amount = $total_price * ($c_percentage);
            $total_price -= $discount_amount;
            $discount_message = "<p class='text-success'>Discount applied! You saved " . number_format($discount_amount, 2) . " ₺</p>";
        } else {
            $discount_message = "<p class='text-danger'>Something went wrong with the coupon.</p>";
        }
    } elseif (isset($_POST['remove_coupon'])) {
        $total_price = $first_price;
        $discount_message = "<p class='text-info'>Coupon removed. Price reverted to original.</p>";
    } else {
        $discount_message = "<p class='text-danger'>Invalid Coupon</p>";
}}

?>


<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
    <title>Yavuzlar Restoran APP</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <meta charset="utf-8">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <style>
        .custom-blue-bg {
    background-color: #007bff; /* Replace this with your desired blue color */
}
    </style>
</head>

<body>
    <div class="container-xxl bg-white p-0">
         <!-- Spinner Start -->
         <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
                <a href="index.php" class="navbar-brand p-0">
                    <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i>Restoran</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0 pe-4">
                        <a href="index.php" class="nav-item nav-link active">Home</a>
                        <?php if(isset($_SESSION['rolee']) && $_SESSION['rolee'] == "company" ){
                            echo '<a href="myrestaurants.php" class="nav-item nav-link">My Restaurants</a>';
                        } elseif(isset($_SESSION['rolee']) && $_SESSION['rolee'] == "user" ){
                            echo '<a href="basket.php" class="nav-item nav-link">Basket</a>';
                        }else{
                            echo '<a href="about.html" class="nav-item nav-link">About</a>';
                        }?>
                        <?php if(isset($_SESSION['rolee']) && $_SESSION['rolee'] == "company" ){
                     echo '<a href="restaurant.php" class="nav-item nav-link">Add Restaurant</a>';
                    } elseif(isset($_SESSION['rolee']) && $_SESSION['rolee'] == "user" ){
                        echo '<a href="orderhistory.php" class="nav-item nav-link">Orders</a>';
                    }else{
                        echo '<a href="booking.html" class="nav-item nav-link">About</a>';
                    }?>
                        <?php if(isset($_SESSION['rolee']) && $_SESSION['rolee'] == "company" ){
                     echo '<a href="resorder.php" class="nav-item nav-link">Orders</a>';
                    } elseif(isset($_SESSION['rolee']) && $_SESSION['rolee'] == "user" ){
                        echo '<a href="menu.php" class="nav-item nav-link">Menu</a>';
                    }else{
                        echo '';
                    }?>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu m-0">
                                <a href="booking.html" class="dropdown-item">Booking</a>
                                <a href="team.html" class="dropdown-item">Our Team</a>
                                <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                            </div>
                        </div>
                        <?php if(isset($_SESSION['username'])){
                     echo '<a href="logout.php" class="nav-item nav-link">LogOut</a>';
                    }?>

                    </div>
                    <?php if(isset($_SESSION['username']) && (isset($_SESSION['rolee']) && !($_SESSION['rolee'] == "admin"))){
                     echo '<a href="profile.php" class="btn btn-primary py-2 px-4">Profile</a>';
                    } elseif(isset($_SESSION['username']) && (isset($_SESSION['rolee']) && ($_SESSION['rolee'] == "admin"))) {
                        echo '<a href="adminpanel.php" class="btn btn-primary py-2 px-4">Admin Panel</a>';
                    }else {
                        echo '<a href="login.php" class="btn btn-primary py-2 px-4">Login</a>';
                    }


                    ?>
                </div>
            </nav>
            <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container my-5 py-5">
                    <div class="row align-items-center g-5">

                    </div>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->
        <!-- Menu Start -->
        <div class="container-xxl py-5">
            
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="section-title ff-secondary text-center text-primary fw-normal">Our Restaurants</h5>
                    <h1 class="mb-5">Explore Our Popular Restaurants</h1>
                </div>
                
                <div class="row g-4">
                    <?php foreach ($meals as $meal): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card restaurant-card">
                            <img src="<?php echo htmlspecialchars($meal['meal_logo']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($meal['meal_name']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($meal['meal_name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($meal['meal_des']); ?></p>
                                <p class="card-text">Price: <?php echo htmlspecialchars($meal['meal_price']); ?> ₺</p>
                                <p class="card-text">Quantity: <?php echo htmlspecialchars($meal['quantity']); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <div class="text-center mt-5">
                        <h3>Total Price for All Meals: <?php echo htmlspecialchars($first_price); ?> ₺</h3>
                    </div>

                    <div class="text-center mt-5">
                        <h3>Your Balance Is: <?php echo htmlspecialchars($balance); ?> ₺</h3>
                    </div>

                    
                    <div class="text-center mt-4">
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="coupon">Enter Coupon Code:</label>
                                <input type="text" name="coupon" id="coupon" class="form-control" placeholder="Coupon Code" style="max-width: 300px; margin: 0 auto;">
                                <button type="submit" name="use_coupon" class="btn btn-primary mt-3">Use Coupon</button>
                                <button type="submit" name="remove_coupon" class="btn btn-secondary mt-3">Remove Coupon</button>
                            </div>
                        </form>
                    </div>

                    
                    <?php if (isset($discount_message)) echo $discount_message; ?>

                    
                    <div class="text-center mt-4">
                        <h3>Final Price after Discount: <?php echo number_format($total_price, 2); ?> ₺</h3>
                    </div>

                    
                    <div class="text-center mt-3">
                        <form method="post" action="basketQuery.php">
                            <input type="hidden" name="c_id" value="<?php echo htmlspecialchars($c_id)?>">
                            <textarea name="note" id="note" placeholder="Please add your note."></textarea>
                            <button type="submit" name="order_now" class="btn btn-primary mt-3">Order Now</button>
                            <input type="hidden" name="final_price" value="<?php echo htmlspecialchars($total_price);?>">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Menu End -->

        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Company</h4>
                        <a class="btn btn-link" href="">About Us</a>
                        <a class="btn btn-link" href="">Contact Us</a>
                        <a class="btn btn-link" href="">Reservation</a>
                        <a class="btn btn-link" href="">Privacy Policy</a>
                        <a class="btn btn-link" href="">Terms & Condition</a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Contact</h4>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Opening</h4>
                        <h5 class="text-light fw-normal">Monday - Saturday</h5>
                        <p>09AM - 09PM</p>
                        <h5 class="text-light fw-normal">Sunday</h5>
                        <p>10AM - 08PM</p>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Newsletter</h4>
                        <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                        <div class="position-relative mx-auto" style="max-width: 400px;">
                            <input class="form-control border-primary w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                            <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="#">Your Site Name</a>, All Right Reserved. 
							
							<!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
							Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a><br><br>
                            Distributed By <a class="border-bottom" href="https://themewagon.com" target="_blank">ThemeWagon</a>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="footer-menu">
                                <a href="">Home</a>
                                <a href="">Cookies</a>
                                <a href="">Help</a>
                                <a href="">FQAs</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
   


    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
