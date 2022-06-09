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
    <title>Total Cases - VSafe</title>

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

    <?php
                $note_result = "";
                if(isset($_GET['caseid']))
                {
                    $id = $_GET['caseid'];
                    $sqlNote = "SELECT note FROM tbl_case WHERE id=$id";
                    $resNote = mysqli_query($conn, $sqlNote);
                    while($rows = mysqli_fetch_assoc($resNote)){
                        $note_result = $rows['note'];
                    }
                }
            ?>
    
</head>
<body>

<?php
    if(isset($_GET['caseid']))
    {
        //Getting the individual case id
        $caseid = $_GET['caseid'];
        //Getting the details of the related case
        $sql = "SELECT * FROM tbl_case WHERE id=$caseid";
        $res = mysqli_query($conn, $sql);
        if($res == true)
        {
            $count = mysqli_num_rows($res);
            if($count>0)
            {
                while($rows = mysqli_fetch_assoc($res))
                {
                    $id = $rows['id'];
                }
            }
        }

    }
?>
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
                    <a href="admin-dashboard.php" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
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
                                    $sql = "SELECT * FROM tbl_department WHERE user_name='$username' AND password='$pwrd'";
                                    $res = mysqli_query($conn,$sql);
                                    if($res == true)
                                    {
                                        $count = mysqli_num_rows($res);
                                        if($count>0)
                                        {
                                            while($rows = mysqli_fetch_assoc($res))
                                            {
                                                $user = $rows['user_name'];
                                                $department = $rows['dep_type'];
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
        <form method="POST">
            <div class="row">
                <div class="addnote col-lg-2">
                    <input type="button" class="notebutton casebox btn btn-primary" data-toggle="modal" data-target="#noteModal" value="Add Note">
                </div>
                <div class="addnote col-lg-2">
                    <input type="submit" id="btnResolved" name="btnResolved" class="notebutton casebox btn btn-primary" value="Resolve">
                </div>
            </div>
        </form>
            <!-- Details Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row">
                <?php 
                    if(isset($_GET['caseid']))
                    {
                        //Getting the individual case id
                        $caseid = $_GET['caseid'];
                        //Getting the details of the related case
                        $sql = "SELECT * FROM tbl_case WHERE id=$caseid";
                        $res = mysqli_query($conn, $sql);
                        if($res == true)
                        {
                            $count = mysqli_num_rows($res);
                            if($count>0)
                            {
                                while($rows = mysqli_fetch_assoc($res))
                                {
                                    $id = $rows['id'];
                                    $situation = $rows['situation'];
                                    $location = $rows['location'];
                                    list($longitude, $latitude) = explode(",",$location);
                                    $datetime = $rows['date_time'];
                                    $details = $rows['details'];
                                    $status = $rows['status'];
                                    if($status == 1)
                                    {
                                        $StatusRes = "Resolved";
                                    }
                                    else{
                                        $StatusRes = "UnResolved";
                                    }
                                }
                            }
                        }
                        
                    }
                    if(isset($_POST['btnResolved']))
                    {
                        if($StatusRes =="Resolved"){
                            $qryUpdateStatus = "UPDATE tbl_case SET status=0 where id='$id'";
                            $resUpdate = mysqli_query($conn, $qryUpdateStatus);
                            $StatusRes = "UnResolved";
                        }
                        else{
                            $qryUpdateStatus = "UPDATE tbl_case SET status=1 where id='$id'";
                            $resUpdate = mysqli_query($conn, $qryUpdateStatus);
                            $StatusRes = "Resolved";
                        }
                        
                    }

                ?>
        <script type="text/javascript">
                var phpStat = "<?php echo $StatusRes ?>"; // case status as a string
                var idcase = "<?php echo $id ?>";   // case id of the required case
                var statcase = "<?php echo $status ?>"; // case status as a integer

                if( phpStat == "Resolved"){
                    document.getElementById('btnResolved').value = "UnResolve";
                }
                else{
                    document.getElementById('btnResolved').value = "Resolve";
                }
                
         </script>
                    <div class="col-md-6">
                        <div class="casebox bg-light text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="sec-title mb-0"><b>Details</b></h6>
                            </div>
                            
                            <div class="row case-details">
                                <div class="col-md-5">Status</div>
                                <div class="col-md-7">: 
                                <?php
                                        if($StatusRes == "Resolved")
                                        {
                                            echo "<span style='background:#33ff33; border-radius:50px; color: #FFF; padding: 1px 5px;'> <b> $StatusRes </b> </span>";
                                        }
                                        else{
                                            echo "<span style='background:#E31E26; border-radius:50px; color: #FFF; padding: 1px 5px;'> <b> $StatusRes </b> </span>";
                                        }
                                    ?>
                                </div>
                            </div>
                              <div class="row case-details">
                                   <div class="col-md-5">Case ID</div>
                                   <div class="col-md-7">: <span> <?php echo $id ?> </span> </div>
                              </div>

                              <div class="row case-details">
                                   <div class="col-md-5">Situation</div>
                                   <div class="col-md-7">: <span> <?php echo $situation ?> </span></div>
                              </div>

                              <div class="row case-details">
                                   <div class="col-md-5">Location</div>
                                   <div class="col-md-7">: <span> <a href="https://www.google.com/maps/search/?api=1&query=<?php echo $longitude,$latitude ?>"><?php echo $longitude,$latitude ?> </a> </span></div>
                              </div>

                              <div class="row case-details">
                                   <div class="col-md-5">Date time</div>
                                   <div class="col-md-7">: <span> <?php echo $datetime ?> </span></div>
                              </div>
                              <div class="row case-details">
                                   <div class="col-md-5">Details</div>
                                   <div class="col-md-7">: <span> <?php echo $details ?> </span></div>
                              </div>
                              <?php
                                    if(isset($_GET['caseid'])){
                                        $idcase = $_GET['caseid'];
                                        $imgqry = "SELECT front_img,back_img FROM tbl_case WHERE id=$idcase GROUP BY id=$idcase";
                                        $imgResult = mysqli_query($conn, $imgqry);
                                        if(mysqli_num_rows($imgResult)>0){
                                            while($imgRow = mysqli_fetch_assoc($imgResult))
                                            {
                                                $front_img = $imgRow['front_img'];
                                                $back_img = $imgRow['back_img'];
                                            }
                                        }
                                    }
                              ?>
                              <div class="row case-details">
                                    <div class="col-md-5">Images</div>
                                        <div class="col-md-7">
                                            <div class="row detailsimg">
                                                <img src="data:images;base64, <?php echo base64_encode($front_img); ?>" alt="front-image" onclick="openModal();currentSlide(1)" class="hover-shadow cursor">
                                            </div>
                                            <div class="row detailsimg">
                                                <img src="data:images;base64, <?php echo base64_encode($back_img); ?>" alt="back-image" onclick="openModal();currentSlide(2)" class="hover-shadow cursor">
                                            </div>
                                        </div>
                              </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="casebox bg-light text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="sec-title mb-0"><b>User Details</b></h6>
                            </div>

                            <?php
                                if(isset($_GET['caseid']))
                                {
                                    $caseId = $_GET['caseid'];
                                    $sql2 = "SELECT * FROM tbl_user INNER JOIN tbl_case ON tbl_case.user_nic = tbl_user.nic INNER JOIN tbl_medical
                                    ON tbl_user.nic = tbl_medical.nic WHERE tbl_case.id=$caseId";
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
                                                $desease[] = $rows2['disease'];
                                                $timePeriod = $rows2['time_period'];
                                                $underTreat = $rows2['under_treatments'];
                                            }
                                        }
                                    }
                                    
                                }
                            ?>

                            <div class="row case-details">
                                <div class="col-md-5">NIC</div>
                                <div class="col-md-7">: <span> <?php echo $nic ?> </span> </div>
                           </div>

                           <div class="row case-details">
                                <div class="col-md-5">First Name</div>
                                <div class="col-md-7">: <span> <?php echo $fname ?> </span></div>
                           </div>

                           <div class="row case-details">
                                <div class="col-md-5">Last Name</div>
                                <div class="col-md-7">: <span> <?php echo $lname ?> </span></div>
                           </div>

                           <div class="row case-details">
                                <div class="col-md-5">Gender</div>
                                <div class="col-md-7">: <span> <?php echo $gender ?> </span></div>
                           </div>
                           <div class="row case-details">
                                <div class="col-md-5">DoB</div>
                                <div class="col-md-7">: <span> <?php echo $dob ?> </span></div>
                           </div>
                           <div class="row case-details">
                                <div class="col-md-5">Address</div>
                                <div class="col-md-7">: <span> <?php echo $address ?> </span></div>
                           </div>
                           <div class="row case-details">
                                <div class="col-md-5">Mobile Number</div>
                                <div class="col-md-7">: <span> <?php echo $mnumber ?> </span></div>
                           </div>
                           <div class="row case-details">
                                <div class="col-md-5">Email</div>
                                <div class="col-md-7">: <span> <?php echo $email ?> </span></div>
                           </div>
                           <div class="row case-details">
                                <div class="col-md-5">Blood Group</div>
                                <div class="col-md-7">: <span> <?php echo $bloodGroup ?> </span></div>
                           </div>
                           <div class="row case-details">
                                <div class="col-md-5">Desease</div>
                                <div class="col-md-7">: <span> <?php print join(', ',$desease); ?> </span></div>
                           </div>
                           <div class="row case-details">
                                <div class="col-md-5">Time Period</div>
                                <div class="col-md-7">: <span> <?php echo $timePeriod ?> </span></div>
                           </div>
                           <div class="row case-details">
                                <div class="col-md-5">Under Treatments</div>
                                <div class="col-md-7">: <span> <?php echo $underTreat ?> </span></div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>

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

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="noteModal" tabindex="-1" role="dialog" aria-labelledby="noteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="">
                <div class="modal-header">
                <h5 class="modal-title" id="noteModalLabel">Add Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <textarea id="notebox" name="notebox" rows="4" cols="50" placeholder="Type here..."><?php
                            echo $note_result;
                        ?></textarea>
                </div>
                <div class="modal-footer">
                     <!-- message after save data -->
                    <?php
                    if(isset($_SESSION['add-note-success'])){
                        echo "<br/>";
                        echo $_SESSION['add-note-success'];
                        unset($_SESSION['add-note-success']);
                        echo "<br/>";
                    }
                    if(isset($_SESSION['add-note-failed'])){
                        echo "<br/>";
                        echo $_SESSION['add-note-failed'];
                        unset($_SESSION['add-note-failed']);
                        echo "<br/>";
                    }
                    ?> 
                <button id="btnClose" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <input  type="submit" id="btnSave" name="btnSave" class="btn btn-primary" value="Save">
                </div>
            </form>

            

            <?php
                
                if(isset($_POST['btnSave']))
                {
                    $id = $_GET['caseid'];
                    $note = $_POST['notebox'];
                    $qry = "UPDATE tbl_case SET note='$note' WHERE id=$id";
                    $resSave = mysqli_query($conn, $qry);
                    if($resSave){
                        $_SESSION['add-note-success'] = "<div style=color: green;>Note Added</div>";
                    }
                    else{
                        $_SESSION['add-note-failed'] = "<div style=color: red;>Something Went Wrong</div>";
                    }
                }
            ?>
        </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imgModal" name="imgModal" class="dimodal">
        <span class="close cursor" onclick="closeModal()">&times;</span>
        <div class="modal-content">
      
          <div class="imgSlides">
            <div class="numbertext">1 / 2</div>
            <img src="data:images/jpg;base64, <?php echo base64_encode($front_img); ?>" alt="front-image" style="width: 100%;">
          </div>
      
          <div class="imgSlides">
            <div class="numbertext">2 / 2</div>
            <img src="data:images/jpg;base64, <?php echo base64_encode($back_img); ?>" alt="back-image" style="width: 100%;">
          </div>
      
          <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
          <a class="next" onclick="plusSlides(1)">&#10095;</a>
      
        </div>
    </div>
    <!-- Image model Script -->
    <script>
        function openModal() {
          document.getElementById("imgModal").style.display = "block";
        }
        
        function closeModal() {
          document.getElementById("imgModal").style.display = "none";
        }
        
        var slideIndex = 1;
        showSlides(slideIndex);
        
        function plusSlides(n) {
          showSlides(slideIndex += n);
        }
        
        function currentSlide(n) {
          showSlides(slideIndex = n);
        }
        
        function showSlides(n) {
          var i;
          var slides = document.getElementsByClassName("imgSlides");
          var dots = document.getElementsByClassName("demo");
          var captionText = document.getElementById("caption");
          if (n > slides.length) {slideIndex = 1}
          if (n < 1) {slideIndex = slides.length}
          for (i = 0; i < slides.length; i++) {
              slides[i].style.display = "none";
          }
          for (i = 0; i < dots.length; i++) {
              dots[i].className = dots[i].className.replace(" active", "");
          }
          slides[slideIndex-1].style.display = "block";
          dots[slideIndex-1].className += " active";
          captionText.innerHTML = dots[slideIndex-1].alt;
        }
    </script>

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