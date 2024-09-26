<?php
session_start();

$user_id = $_SESSION["id"];
$username = $_SESSION["username"];
$fname = $_SESSION["fname"];
$surname = $_SESSION["surname"];
$balance = $_SESSION["balance"];
$pp_path = $_SESSION["pp_path"];
$rolee = $_SESSION["rolee"];


if (empty($pp_path)){
    $pp_path = "./uploaded_files/Default_pfp.jpg";
}



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <title>Profile - User</title>

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <style>
        .profile-info {
            position: relative;
            margin-bottom: 15px;
        }

        .edit-icon {
            display: none;
            position: absolute;
            top: 0;
            right: 10px;
            cursor: pointer;
        }

        .profile-info:hover .edit-icon {
            display: inline-block;
        }

        .edit-mode {
            display: block;
        }

        .normal-mode {
            display: none;
        }

        .hidden {
            display: none;
        }

        .profile-image {
            display: block;
            margin-bottom: 20px;
            text-align: center;
        }

        .profile-image img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }

        .file-upload {
            margin-bottom: 20px;
            text-align: center;
        }

        .submit-btn {
            display: none;
            margin-top: 20px;
        }
    </style>

    <script>
        function handleRoleChange() {
            var role = document.getElementById('role').textContent;
            var usernameLabel = document.getElementById('username-label');
            
            if (role === 'Company') {
                usernameLabel.textContent = 'Company Name';
            } else {
                usernameLabel.textContent = 'Username';
            }
        }

        function enableEdit(field) {
            const displayElement = document.getElementById(field + '-display');
            const inputElement = document.getElementById(field + '-input');
            const submitButton = document.getElementById('submit-btn');

            if (inputElement.classList.contains('normal-mode')) {
                inputElement.classList.remove('normal-mode');
                inputElement.classList.add('edit-mode');
                displayElement.style.display = 'none';
                submitButton.style.display = 'block';
            } else {
                inputElement.classList.add('normal-mode');
                inputElement.classList.remove('edit-mode');
                displayElement.style.display = 'block';
                displayElement.innerText = inputElement.value;
                submitButton.style.display = 'none';
            }
        }

        function handleFileChange(event) {
            const file = event.target.files[0];
            const image = document.getElementById('profile-image');
            const reader = new FileReader();

            reader.onload = function(e) {
                image.src = e.target.result;
                document.getElementById('submit-btn').style.display = 'block';
            };

            reader.readAsDataURL(file);
        }
    </script>
</head>

<body onload="handleRoleChange()">
    <div class="container-xxl bg-white p-0">


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
                     echo '';
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


        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="section-title ff-secondary text-center text-primary fw-normal">Profile</h5>
                    <h1 class="mb-5">Your Profile Information</h1>
                </div>
                <div class="row g-4">
                    <div class="col-md-6 offset-md-3 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="card border-0 shadow rounded-4">
                            <div class="card-body p-4 p-sm-5">
                                <form action="profileQuery.php" method="post" enctype="multipart/form-data">
                                <div class="row g-3">

                                    <div class="col-md-12 profile-image">
                                        <img id="profile-image" src="<?php echo $pp_path ?>" alt="Profile Image">
                                        <input type="file" id="profile-image-upload" name="pp_path" class="file-upload" onchange="handleFileChange(event)">
                                    </div>


                                    <div class="col-md-12">
                                        <div class="profile-info">
                                            <strong>Role:</strong>
                                            <p id="role" name="role"><?php echo $rolee?></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="profile-info">
                                            <strong>First Name:</strong>
                                            <span id="first-name-display"><?php echo $fname ?></span>
                                            <i class="edit-icon fas fa-edit" onclick="enableEdit('first-name')"></i>
                                            <input type="text" id="first-name-input" name="fname" class="normal-mode" value="<?php echo $fname ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="profile-info">
                                            <strong>Last Name:</strong>
                                            <span id="last-name-display"><?php echo $surname ?></span>
                                            <i class="edit-icon fas fa-edit" onclick="enableEdit('last-name')"></i>
                                            <input type="text" id="last-name-input" name="surname" class="normal-mode" value="<?php echo $surname ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="profile-info">
                                            <strong id="username-label">Username</strong>
                                            <span id="username-display"><?php echo $username ?></span>
                                            <i class="edit-icon fas fa-edit" onclick="enableEdit('username')"></i>
                                            <input type="text" id="username-input" name="username" class="normal-mode" value="<?php echo $username ?>">
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="submit" id="submit-btn" name="submit"class="btn btn-primary submit-btn">Submit</button>
                                </form>
                                <form action="profileQuery.php" method = "post" enctype ="multipart/form-data">
                                <div class="position-relative mx-auto" style="max-width: 400px;">
                            <input class="form-control border-primary w-100 py-3 ps-4 pe-5" name="balance"type="text" placeholder="Add Balance">
                            <p>Your Balance is <?php echo $balance;?>₺</p>
                            <button type="submit" name="balance_user_id" value="<?php echo $user_id ?>" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">Add Balance</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
    </div>
</body>

</html>
