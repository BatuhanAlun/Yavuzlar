<?php

session_start();
include "functions/functions.php";

$res_id = $_GET['id'];
$user_id = $_SESSION['id'];
$username = $_SESSION['username'];
if(isset($_GET['searchbar'])){
    $search = $_GET['searchbar'];
    $meals = searchMeal($search,$res_id);
}else {
    $meals = getMealBy_id($res_id);
}
$comments = getCommentBy_id($res_id);

if (empty($meals)){
    echo "Sorry there is no meals for that restaurant";
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Restoran - Bootstrap Restaurant Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    

    <style>
        * {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}
:root {
  font-size: 16px;
}
body {
  color: black;
  font-family: sans-serif;
  font-size: 1rem;
}
.fa-star {
    color: lightgray; /* Default color for unselected stars */
}

.fa-star.checked {
    color: gold; /* Color for filled stars */
}


.wrapper {
  max-width: 65ch;
  margin: 0 auto;
  padding: 0 2rem;
}

.call-to-action-text {
  margin: 2rem 0;
  text-align: left;
}
.star-wrap {
  width: max-content;
  margin: 0 auto;
  position: relative;
}
.star-label.hidden {
  display: none;
}
.star-label {
  display: inline-flex;
  justify-content: center;
  align-items: center;
  width: 24px;
  height: 24px;
}
@media (min-width: 840px) {
  .star-label {
    width: 40px;
    height: 40px;
  }
}

.star-shape {
  background-color: gold;
  width: 80%;
  height: 80%;
  /*star shaped cutout, works  best if it is applied to a square*/
  /* from Clippy @ https://bennettfeely.com/clippy/ */
  clip-path: polygon(
    50% 0%,
    61% 35%,
    98% 35%,
    68% 57%,
    79% 91%,
    50% 70%,
    21% 91%,
    32% 57%,
    2% 35%,
    39% 35%
  );
}

/* make stars *after* the checked radio gray*/
.star:checked + .star-label ~ .star-label .star-shape {
  background-color: lightgray;
}

/*hide away the actual radio inputs*/
.star {
  position: fixed;
  opacity: 0;
  /*top: -90000px;*/
  left: -90000px;
}

.star:focus + .star-label {
  outline: 2px dotted black;
}
.skip-button {
  display: block;
  width: 2rem;
  height: 2rem;
  border-radius: 1rem;
  position: absolute;
  top: -2rem;
  right: -1rem;
  /*transform: translateY(-50%);*/
  text-align: center;
  line-height: 2rem;
  font-size:2rem;
  background-color: rgba(255, 255, 255, 0.1);
}
.skip-button:hover {
  background-color: rgba(255, 255, 255, 0.2);
}
#skip-star:checked ~ .skip-button {
  display: none;
}
#result {
  text-align: center;
  padding: 1rem 2rem;
}
.exp-link {
  text-align: center;
  padding: 1rem 2rem;
 }
.exp-link a{
  color: lightgray;
  text-decoration:underline;
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
                        } elseif(isset($_SESSION['rolee']) && $_SESSION['rolee'] == "user" || $_SESSION['rolee'] == "admin"  ){
                            echo '<a href="basket.php" class="nav-item nav-link">Basket</a>';
                        }else{
                            echo '<a href="about.html" class="nav-item nav-link">About</a>';
                        }?>
                        <?php if(isset($_SESSION['rolee']) && $_SESSION['rolee'] == "company" ){
                     echo '<a href="restaurant.php" class="nav-item nav-link">Add Restaurant</a>';
                    } elseif(isset($_SESSION['rolee']) && $_SESSION['rolee'] == "user" || $_SESSION['rolee'] == "admin"  ){
                        echo '<a href="orderhistory.php" class="nav-item nav-link">Orders</a>';
                    }else{
                        echo '<a href="booking.html" class="nav-item nav-link">About</a>';
                    }?>
                        <?php if(isset($_SESSION['rolee']) && $_SESSION['rolee'] == "company" ){
                     echo '<a href="resorder.php" class="nav-item nav-link">Orders</a>';
                    } elseif(isset($_SESSION['rolee']) && $_SESSION['rolee'] == "user" || $_SESSION['rolee'] == "admin" ){
                        echo '<a href="menu.php" class="nav-item nav-link">Menu</a>';
                    }else{
                        echo '';
                    }?>
                        <!-- <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu m-0">
                                <a href="booking.html" class="dropdown-item">Booking</a>
                                <a href="team.html" class="dropdown-item">Our Team</a>
                                <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                            </div>
                        </div> -->
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

                <form class="mb-4" action="restaurant_details.php" method="GET">
                    <div class="input-group">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($res_id); ?>">
                        <input type="search" class="form-control" placeholder="Search for meals..." name="searchbar">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </form>


                <div class="row g-4">
                    <?php foreach ($meals as $meal): ?>
                    <div class="col-lg-4 col-md-6">
                            <div class="card restaurant-card">
                                <img src="<?php echo htmlspecialchars($meal['meal_logo']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($meal['meal_name']); ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($meal['meal_name']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($meal['meal_des']); ?></p>
                                    <?php if (isset($meal['meal_discount']) && $meal['meal_discount'] > 0): ?>
                                                               
                                                                <del><?php echo $meal['meal_price'] ?> ₺</del> 
                                                               
                                                                <span class="discounted-price">
                                                                    <?php
                                                                        $discounted_price = $meal['meal_price'] - ($meal['meal_price'] * $meal['meal_discount'] / 100);?>
                                                                        <p class="card-text"><?php echo htmlspecialchars($discounted_price); ?> ₺</p>

                                                                </span>
                                                            <?php else: ?>
                                                               
                                                                <p class="card-text"><?php echo htmlspecialchars($meal['meal_price']); ?> ₺</p>
                                                            <?php endif; ?>
                                </div>
                                <div class="mt-auto d-flex justify-content-end">
                                <form method="post" action="res_detailQuery.php?id=<?php echo $res_id ?>" enctype = "mutlipart/form-data">
                                    <input type="hidden" name="meal_id" value="<?php echo htmlspecialchars($meal['id']); ?>">
                                    <button type="submit" name="add_basket" class="btn btn-primary">Add to the Basket</button>
                                </form>
                               </div>
                            </div>
                    </div>
                    <?php endforeach; ?>
                </div>

        <!-- Menu End -->

<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h5 class="section-title ff-secondary text-center text-primary fw-normal">Share Your Opinions</h5>
            <h1 class="mb-5">Comment Section</h1>
        </div>
        <div class="row g-4">
            <div class="col-md-6 offset-md-3 wow fadeInUp" data-wow-delay="0.1s">
                <div class="card border-0 shadow rounded-4">
                    <div class="card-body p-4 p-sm-5">
                        <form action="addcomment.php" method="post" enctype="multipart/form-data">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <textarea type="textarea" class="form-control" id="comment" name="comment" placeholder="Enter Your Comment" required></textarea>
                                        <input type="hidden" name="res_id" value="<?php echo htmlspecialchars($res_id); ?>">

                                        <label for="comment" id="comment-label">Comment</label>
                                    </div>
                                </div>
                                <div class="wrapper">
                                    <form action="addcomment.php" name="star-rating-form">
                                        <h3 id="title" class="call-to-action-text">Select a rating:</h3>
                                        <div class="star-wrap">
                                            <input class="star" checked type="radio" value="0" id="skip-star" name="star-radio" autocomplete="off" />
                                            <label class="star-label hidden"></label>
                                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                                <input class="star" type="radio" id="st-<?php echo $i; ?>" value="<?php echo $i; ?>" name="star-radio" autocomplete="off" />
                                                <label class="star-label" for="st-<?php echo $i; ?>">
                                                    <div class="star-shape"></div>
                                                </label>
                                            <?php endfor; ?>
                                            <label class="skip-button" for="skip-star">&times;</label>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Submit Comment</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


         <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="section-title ff-secondary text-center text-primary fw-normal">Comments</h5>
                    <h1 class="mb-5">Comments</h1>
                </div>

                <div class="row g-4">
                    <?php foreach ($comments as $comment): ?>
                    <div class="col-lg-4 col-md-6">
                            <div class="card restaurant-card">
                                <div class="card-body">
                                    <h5 class="card-title">Username:<?php echo htmlspecialchars($comment['username']); ?></h5>
                                    <h5 class="card-text">Comment:<?php echo htmlspecialchars($comment['comment']); ?></h5>
                                    <div>
                                            <?php for ($i = 1; $i <= $comment['score']; $i++): ?>
                                                <span class="fa fa-star checked"></span>
                                            <?php endfor; ?>
                                            <?php for ($j = 1; $j <= 10 - $comment['score']; $j++): ?>
                                                <span class="fa fa-star"></span>
                                            <?php endfor; ?>
                                        </div>
                                    </form>
                                </div>
                            </div>
                    </div>
                    <?php endforeach; ?>
                </div>

 

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
