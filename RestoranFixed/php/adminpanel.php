<?php
session_start();

include "functions/functions.php";


if(isset($_GET['customer_name'])){
    $query = $_GET['customer_name'];
    $customers = searchcustomer($query);



}elseif(isset($_GET['customerfilter']) ){
    $query = $_GET['customerfilter'];
    $customers = filtercustomer($query);

}

else{
    $customers = getCustomers();
}

if(isset($_GET['company_name'])){
    $query = $_GET['company_name'];
    $companies = searchcompanies($query);



} else{
    $companies = getCompanies();
}













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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="js/bootstrap.bundle.min.js"></script>
</head>

<body>
    
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center">
                <h1 class="mb-5">Admin Panel</h1>
            </div>
            <div class="row g-4">
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
                
                
                <div class="col-md-12">

                    <h3>Customer Management</h3>
                    <div class="mb-3">
                        <h5>Customer Search</h5>
                        <form action="adminpanel.php" method="GET">
                            <input type="text" name="customer_name" placeholder="Enter customer username" class="form-control">
                            <button type="submit" class="btn btn-primary mt-2">Search</button>
                        </form>
                    </div>
                        
                        <div class="mb-3">
                        <h5>Customer Filtering</h5>
                        <form action="adminpanel.php" method="GET">
                            <select name="customerfilter" class="form-select">
                                <option value="all">All Customers</option>
                                <option value="1">Deleted Customers</option>
                                <option value="0">Not Deleted Customers</option>
                            </select>
                            <button type="submit" class="btn btn-primary mt-2">Filter</button>
                        </form>
                    </div>
                </div>

                    
                    <div class="mb-3">
                        <h5>Customer Listing</h5>
                        
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Customer ID</th>
                                    <th>Name</th>
                                    <th>Surname</th>
                                    <th>Username</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($customers as $customer): ?>
                                <tr>
                                    <td><?php echo $customer['id']; ?></td>
                                    <td><?php echo $customer['fname']; ?></td>
                                    <td><?php echo $customer['surname']; ?></td>
                                    <td><?php echo $customer['username']; ?></td>
                                    <td><?php echo $customer['deleted'] ? 'Deleted' : 'Active'; ?></td>
                                    <td>
                                        
                                        <?php if (!$customer['deleted']): ?>
                                        <form action="banCustomer.php" method="POST">
                                            <input type="hidden" name="customer_id" value="<?php echo $customer['id']; ?>">
                                            <button type="submit" class="btn btn-danger">Ban</button>
                                        </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mb-3">
                        <h5>Customer Order Listing</h5>
                        
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Customer ID</th>
                                    <th>Username</th>
                                    <th>Order Status</th>
                                    <th>Total Price</th>
                                    <th>Order Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($customers as $customer): ?>
                                <tr>
                                    <td><?php echo $customer['id']; ?></td>
                                    <td><?php echo $customer['username']; ?></td>
                                    <?php $orders = getAllPendingOrdersForUser($customer['id'])?>
                                    <?php foreach ($orders as $order): ?>
                                        <td><?php echo $order['status']; ?></td>
                                        <td><?php echo $order['total_price']; ?></td>
                                        <td><?php echo $order['order_date']; ?></td>
                                        <?php endforeach; ?>
                                    <td>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    




                
                <div class="col-md-12">
                    <h3>Company Management</h3>

                    
                    
                    <div class="mb-3">
                        <h5>Search Company</h5>
                        <form action="adminpanel.php" method="GET">
                            <input type="text" name="company_name" placeholder="Enter company name" class="form-control">
                            <button type="submit" class="btn btn-primary mt-2">Search</button>
                        </form>
                    </div>
                </div>


                
                <div class="mb-3">
                    <h5>Company Listing</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Company ID</th>
                                <th>Company Name</th>
                                <th>Meals Offered</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($companies as $company): ?>
                            <tr>
                                <td><?php echo $company['id']; ?></td>
                                <td>
                                <div class="col-md-6">
                                    <div class="profile-info">
                                        <form action="updateCompany.php" method="post" enctype = "multipart/form-data">
                                        <strong>Company Name:</strong>
                                        <span id="company-name-display"><?php echo $company['username']; ?></span>
                                        <i class="edit-icon fas fa-edit" onclick="enableEdit('company-name')"></i>
                                        <input type="text" id="company-name-input" name="company_name" class="normal-mode" value="<?php echo $company['username']; ?>" style="display:none;">
                                    </div>
                                    
                                </div>

                                </td>
                                <td>

                                    <ul>
                                        <?php $meals = getMealData($company['id'])?>
                                        <?php foreach ($meals as $meal): ?>
                                        <li><?php echo $meal['meal_name']; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                                <td><?php echo $company['deleted'] ? 'Deleted' : 'Active'; ?></td>
                                <td>

                                    <button value="<?php echo $company['id']; ?>"  name ="company_id" type="submit" class="btn btn-warning">Update</button>
                                    </form>       
                                    
                                    <?php if (!$company['deleted']): ?>
                                    <form action="banCustomer.php" method="POST">
                                        <input type="hidden" name="customer_id" value="<?php echo $company['id']; ?>">
                                        <button type="submit" class="btn btn-danger mt-2">Delete</button>
                                    </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                    
                    <div class="mb-3">
                        <h5>Add New Company</h5>
                        <div class="row g-4">
                    <div class="col-md-6 offset-md-3 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="card border-0 shadow rounded-4">
                            <div class="card-body p-4 p-sm-5">
                                <form action="registeradmincompany.php" method="post" enctype="multipart/form-data">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" required>
                                                <label for="name">First Name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="surname" name="surname" placeholder="Last Name" required>
                                                <label for="surname">Last Name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                                                <label for="username" id="username-label">Company Name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-floating">
                                                <input type="password" class="form-control" id="passwd" name="passwd" placeholder="Password" required>
                                                <label for="password">Password</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100 py-3" type="submit">Register</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                    </div>

                    
                    <div class="mb-3">
                        <h5>Search Company</h5>
                        <form action="adminpanel.php" method="GET">
                            <input type="text" name="company_name" placeholder="Enter company name" class="form-control">
                            <button type="submit" class="btn btn-primary mt-2">Search</button>
                        </form>
                    </div>
                </div>

                
                <div class="col-md-12">
                    <h3>Coupon Management</h3>

                    
                    <div class="mb-3">
                        <h5>Add New Coupon</h5>
                        <form action="addCoupon.php" method="POST">
                            <input type="text" name="coupon_name" placeholder="Coupon Name" class="form-control" required>
                            <input type="number" name="percentage" placeholder="Discount Percentage" class="form-control mt-2" required>
                            <button type="submit" class="btn btn-primary mt-2">Add Coupon</button>
                        </form>
                    </div>

                    
                    <div class="mb-3">
                        <h5>Delete Coupon</h5>
                        <form action="addCoupon.php" method="POST">
                            <?php $coupons = getCoupons();?>
                            <select name="coupon_id" class="form-select" required>
                                <?php foreach ($coupons as $coupon): ?>
                                <option value="<?php echo $coupon['id']; ?>"><?php echo $coupon['c_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button name ="delete-btn"type="submit" class="btn btn-danger mt-2">Delete Coupon</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-chevron-up"></i></a>

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
    <script>
function enableEdit(field) {
    const displayElement = document.getElementById(field + '-display');
    const inputElement = document.getElementById(field + '-input');
    const submitButton = document.getElementById('submit-btn');

    if (inputElement.style.display === 'none') {
        displayElement.style.display = 'none';
        inputElement.style.display = 'inline-block';
        inputElement.focus();
        submitButton.style.display = 'block';
    } else {
        displayElement.style.display = 'inline-block';
        inputElement.style.display = 'none';
        displayElement.innerText = inputElement.value;
        submitButton.style.display = 'none';
    }
}
</script>

</body>

</html>
