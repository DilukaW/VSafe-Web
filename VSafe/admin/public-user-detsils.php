<?php
    include 'connection.php';
    include 'login-check.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public User Details - VSafe</title>

    <link href="https://fonts.googleapis.com/css?family=Asap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Start - Background -->
    <div class="bg"></div>
    <div class="bg bg2"></div>
    <div class="bg bg3"></div>
    <!-- End - Background -->
    
    <div class="container-xxl position-relative bg-none d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <a href="admin-dashboard.php">
                <div class="toplogo bg-white">
                    <div>
                        <img src="images/pure logo.png" alt="" style="width: 200px;">
                    </div>
                </div>
            </a>
            <nav class="navbar navbar-light">
                    <div class="navbar-nav w-100">
                    <a href="admin-dashboard.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Cases</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="todaycases.php" class="dropdown-item"><i class="far fa-file-alt me-2"></i>Today Cases</a>
                            <a href="cases.php" class="dropdown-item"><i class="far fa-file-alt me-2"></i>Total Cases</a>
                            <a href="resolvedcases.php" class="dropdown-item"><i class="far fa-file-alt me-2"></i>Resolved Cases</a>
                            <a href="unresolvedcases.php" class="dropdown-item "><i class="far fa-file-alt me-2"></i>Unresolved Cases</a>
                        </div>
                    </div>
                    <a href="analytics.php" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Analytics</a>
                    <a href="public-users.php" class="nav-item nav-link"><i class="fa fa-user me-2"></i>Public Users</a>
                    <a href="users.php" class="nav-item nav-link"><i class="fa fa-user me-2"></i>Department Users</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand casebox bg-light navbar-light sticky-top px-4 py-0">
                <a href="#" class="sidebar-toggler flex-shrink-0" style="color: #E31E26;">
                    <i class="fa fa-bars" style="color: white;"></i>
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="images/pro-pic.png" alt="Profile Pic" style="width: 40px; height: 40px;">
                            <span class="user d-none d-lg-inline-flex">
                            <?php
                                    //Getting the details from the database
                                    $username = $_SESSION['admin-user'];
                                    $pwrd = $_SESSION['pwrd'];
                                    $sql = "SELECT * FROM tbl_admin WHERE user_name='$username' AND password='$pwrd'";
                                    $res = mysqli_query($conn,$sql);
                                    if($res == true)
                                    {
                                        $count = mysqli_num_rows($res);
                                        if($count>0)
                                        {
                                            while($rows = mysqli_fetch_assoc($res))
                                            {
                                                $user = $rows['user_name'];
                                                $department = $rows['admin_type'];
                                                echo $user;
                                            }
                                        }
                                    }
                                ?>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end border-0 rounded-0 rounded-bottom m-0">
                            <a href="user-details.php" class="dropdown-item">Profile</a>
                            <a href="logout.php" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->
            
            <!-- Public User Details Start -->
            <div class="detailsbox container-fluid bg-light pt-4 px-4">
                <div class="row">
                <?php
                if(isset($_GET['userNic']))
                {
                    $userNic = $_GET['userNic'];
                    $sql2 = "SELECT * FROM tbl_user INNER JOIN tbl_medical ON tbl_user.nic = tbl_medical.nic WHERE tbl_user.nic='$userNic'";
                    $res2 = mysqli_query($conn, $sql2);
                    if($res2 == true)
                    {
                        $count2 = mysqli_num_rows($res2);
                        if($count2 >0)
                        {
                            $desease = array();
                            while($rows2 = mysqli_fetch_assoc($res2))
                            {
                                $nic = $rows2['nic'];
                                $fname = $rows2['first_name'];
                                $lname = $rows2['last_name'];
                                $gender = $rows2['gender'];
                                $dob = $rows2['dob'];
                                $address = $rows2['address'];
                                $mnumber = $rows2['mob_number'];
                                $email = $rows2['email'];
                                $bloodGroup = $rows2['blood_group'];
                                $fullname = "$fname $lname";
                                $desease[] = $rows2['disease'];
                                $timePeriod = $rows2['time_period'];
                                $treatments = $rows2['under_treatments'];
                            }
                        }
                    }
                }
            ?>
                    <div class="col-md-5">
                        <div class="bg-light text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4" style="text-align: center;">
                                <h6 class="username mb-0"><b><?php echo $fullname ?></b></h6>
                            </div>
                            <div class="col-md-2">
                                <img class="userimage rounded-circle me-lg-2" src="images/pro-pic.png" alt="Profile Pic" style="width: 180px; height: 180px;">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="bg-light text-center rounded p-4">
                            <div class="row case-details" style="padding-top: 40px;">
                                <div class="col-md-5">NIC</div>
                                <div class="col-md-7">: <span><?php echo $userNic ?></span> </div>
                           </div>

                           <div class="row case-details">
                                <div class="col-md-5">First Name</div>
                                <div class="col-md-7">: <span><?php echo $fname ?></span></div>
                           </div>

                           <div class="row case-details">
                                <div class="col-md-5">Last Name</div>
                                <div class="col-md-7">: <span><?php echo $lname ?></span></div>
                           </div>

                           <div class="row case-details">
                                <div class="col-md-5">Gender</div>
                                <div class="col-md-7">: <span><?php echo $gender ?></span></div>
                           </div>
                           <div class="row case-details">
                                <div class="col-md-5">DoB</div>
                                <div class="col-md-7">: <span><?php echo $dob ?></span></div>
                           </div>
                           <div class="row case-details">
                                <div class="col-md-5">Address</div>
                                <div class="col-md-7">: <span><?php echo $address ?></span></div>
                           </div>
                           <div class="row case-details">
                                <div class="col-md-5">Mobile Number</div>
                                <div class="col-md-7">: <span><?php echo $mnumber ?></span></div>
                           </div>
                           <div class="row case-details">
                                <div class="col-md-5">Email</div>
                                <div class="col-md-7">: <span><?php echo $email ?></span></div>
                           </div>
                           <div class="row case-details" style="padding-bottom: 30px;">
                                <div class="col-md-5">Blood Group</div>
                                <div class="col-md-7">: <span><?php echo $bloodGroup ?></span></div>
                           </div>
                           <div class="row case-details" style="padding-bottom: 30px;">
                                <div class="col-md-5">Desease</div>
                                <div class="col-md-7">: <span><?php print join(', ',$desease); ?></span></div>
                           </div>
                           <div class="row case-details" style="padding-bottom: 30px;">
                                <div class="col-md-5">Time Period</div>
                                <div class="col-md-7">: <span><?php echo $timePeriod ?></span></div>
                           </div>
                           <div class="row case-details" style="padding-bottom: 30px;">
                                <div class="col-md-5">Under Treatments</div>
                                <div class="col-md-7">: <span><?php echo $treatments ?></span></div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Public User Details End -->

            <!-- Start - Footer -->
            <footer id="sticky-footer">
        
                <!-- Copyright -->
                <div class="text-center p-4">
                    © 2022 
                <a class="text-reset fw-bold" href="https://vsafe.care/">VSafe</a>
                - All Rights Reserved
                </div>
                <!-- Copyright -->
            </footer>
            <!--End - Footer -->
    </div>

    <!-- Modal -->
    <!--
    <div class="modal fade" id="noteModal" tabindex="-1" role="dialog" aria-labelledby="noteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="noteModalLabel">Add Note</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border: none;">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <textarea id="notebox" name="note" rows="4" cols="50" placeholder="Type here..."></textarea>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
        </div>
    </div>
    -->
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    
</body>
</html>