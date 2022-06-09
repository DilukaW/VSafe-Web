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
    <meta http-equiv="refresh" content="60"> <!-- To refresh the webpage in every 1 minute -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart Js script -->
    <title>Dashboard - Vsafe</title>

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
    <!-- To get the Count of cases and put them on the banners -->
    <?php
        $qryCount = "SELECT COUNT(id) AS Total,
                            COUNT(case when status=1 then 1 end) AS Resolved,
                            COUNT(case when status=0 then 1 end) AS UnResolved
                            FROM tbl_case";
        $ResCount = mysqli_query($conn,$qryCount);
        if($cnt =mysqli_fetch_assoc($ResCount)){
            $total = $cnt['Total']; //Total case count
            $resolved = $cnt['Resolved'];   //Resolved Cases count
            $unResolved = $cnt['UnResolved'];   //Unresolved cases count
        }
        $qryTodayCount = "SELECT * FROM tbl_case WHERE DATE(date_time) = CURDATE()";
        $resTodayCount = mysqli_query($conn, $qryTodayCount);
        $cntToday = mysqli_num_rows($resTodayCount);    //Today cases count

    ?>
</head>
<body>
    <!-- Start - Background -->
    <div class="bg"></div>
    <div class="bg bg2"></div>
    <div class="bg bg3"></div>
    <!-- End - Background -->
    
    <div class="container-xxl position-relative bg-none d-flex p-0" style="max-width: 1350px;">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <a href="dashboard.php">
                <div class="toplogo bg-white">
                    <div>
                        <img src="images/pure logo.png" alt="" style="width: 200px;">
                    </div>
                </div>
            </a>
            <nav class="navbar navbar-light">
                    <div class="navbar-nav w-100">
                    <a href="dashboard.php" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
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
                                    $username = $_SESSION['user'];
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


            <!-- Cases Panel Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="casebox bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-line fa-3x text-primary"></i>
                            <div class="ms-3">
                                <a href="cases.php">
                                    <p class="cases mb-2">Total Cases</p>
                                    <h6 class="mb-0">
                                        <?php echo $total; ?>
                                    </h6>
                                </a>    
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="casebox bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-bar fa-3x text-primary"></i>
                            <div class="ms-3">
                                <a href="resolvedcases.php">
                                    <p class="cases mb-2">Resolved Cases</p>
                                    <h6 class="mb-0">
                                        <?php echo $resolved; ?>
                                    </h6>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="casebox bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-area fa-3x text-primary"></i>
                            <div class="ms-3">
                                <a href="unresolvedcases.php">
                                    <p class="cases mb-2">Unresolved Cases</p>
                                    <h6 class="mb-0">
                                        <?php echo $unResolved; ?>
                                    </h6>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="casebox bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-pie fa-3x text-primary"></i>
                            <div class="ms-3">
                                <a href="todaycases.php">
                                    <p class="cases mb-2">Today Cases</p>
                                    <h6 class="mb-0">
                                        <?php echo $cntToday; ?>
                                    </h6>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Cases Panel End -->


            <!-- Case Boxes Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="casebox bg-light text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Today Cases</h6>
                            </div>
                            <div class="caseboxtable table-responsive">
                                <table class="table text-start align-middle table-bordered table-hover mb-0">
                                    <tbody>
                                        <?php include('todaycases1.php'); ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="casebox bg-light text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Today Unresolved Cases</h6>
                            </div>
                            <div class="caseboxtable table-responsive">
                                <table class="table text-start align-middle table-bordered table-hover mb-0">
                                    <tbody>
                                        <?php include('todayUnresolvedcases.php'); ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Case Boxes End -->

            <!-- Cases Chart Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <!-- Weekly Resolved/Unresolved Case data php -->
                            <?php 
                                $sqlMultiBarWeekly = "SELECT
                                            Week(date_time) AS Week,
                                            COUNT(case when status=1 then 1 end) AS Resolved,
                                            COUNT(case when status=0 then 1 end) AS UnResolved,
                                            COUNT(*) as Total_Cases
                                        FROM tbl_case
                                        GROUP BY Week(date_time);";
                                $res = mysqli_query($conn, $sqlMultiBarWeekly);
                                foreach($res as $data)
                                {
                                    $week[] = $data['Week'];
                                    $Rescaseamount[] = $data['Resolved'];
                                    $UnRescaseamount[] = $data['UnResolved'];
                                    $Totalcaseamount[] = $data['Total_Cases'];
                                }
                            ?>
                        <div class="casebox bg-light text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Weekly</h6>
                                <a href="analytics.php">Show All</a>
                            </div>
                            <canvas id="myWeeklyMultiBarChart"></canvas>
                        </div>
                    <!-- Weekly Resolved/UnREsolved cases Script -->
                    <script>
                        const labelsMultiBar = <?php echo json_encode($week) ?>;
                        const dataMultiBar = {
                            labels: labelsMultiBar,
                            datasets: [{
                            label: 'Resolved Cases',
                            data: <?php echo json_encode($Rescaseamount) ?>,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgb(255, 99, 132)',
                            borderWidth: 1
                            },{
                            label: 'UnResolved Cases',
                            data: <?php echo json_encode($UnRescaseamount) ?>,
                            backgroundColor: 'rgba(255, 159, 64, 0.2)',
                            borderColor: 'rgb(255, 159, 64)',
                            borderWidth: 1
                            },{
                            label: 'Total Cases',
                            data: <?php echo json_encode($Totalcaseamount) ?>,
                            backgroundColor:'rgba(51, 153, 255, 0.2)',
                            borderColor: 'rgb(51, 153, 255)',
                            borderWidth: 1
                            }]
                        };

                        const configMultiBar = {
                            type: 'bar',
                            data: dataMultiBar,
                            options: {
                            scales: {
                                y: {
                                beginAtZero: true
                                }
                            }
                            },
                        };

                        var myMultiBarChart = new Chart(
                            document.getElementById('myWeeklyMultiBarChart'),
                            configMultiBar
                        );
                    </script>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="casebox bg-light text-center rounded p-4">
                            <!-- Monthly Resolved/Unresolved Case data linechart php -->
                            <?php 
                                $sqlMultiLineMonthly = "SELECT
                                            Month(date_time) AS Month,
                                            COUNT(case when status=1 then 1 end) AS Resolved,
                                            COUNT(case when status=0 then 1 end) AS UnResolved,
                                            COUNT(*) as Total_Cases
                                        FROM tbl_case
                                        GROUP BY Month(date_time);";
                                $res = mysqli_query($conn, $sqlMultiLineMonthly);
                                foreach($res as $data)
                                {
                                    switch($data['Month']){
                                        case 1: $month[] = "January";break;
                                        case 2: $month[] = "February";break;
                                        case 3: $month[] = "March";break;
                                        case 4: $month[] = "April";break;
                                        case 5: $month[] = "May";break;
                                        case 6: $month[] = "June"; break;
                                        case 7: $month[] = "July"; break;
                                        case 8: $month[] = "August"; break;
                                        case 9: $month[] = "September"; break;
                                        case 10: $month[] = "October"; break;
                                        case 11: $month[] = "November"; break;
                                        case 12: $month[] = "December"; break; 
                                      }
                                    $RescaseamountMonthly[] = $data['Resolved'];
                                    $UnRescaseamountMonthly[] = $data['UnResolved'];
                                    $TotalcaseamountMonthly[] = $data['Total_Cases'];
                                }
                            ?>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Monthly</h6>
                                <a href="analytics.php">Show All</a>
                            </div>
                            <canvas id="myMonthlyMultiLineChart"></canvas>
                        </div>
                        <!-- Weekly Resolved/UnREsolved cases Script -->
                    <script>
                        const labelsMultiLine = <?php echo json_encode($month) ?>;
                        const dataMultiLine = {
                            labels: labelsMultiLine,
                            datasets: [{
                            label: 'Resolved Cases',
                            data: <?php echo json_encode($RescaseamountMonthly) ?>,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgb(255, 99, 132)',
                            borderWidth: 1
                            },{
                            label: 'UnResolved Cases',
                            data: <?php echo json_encode($UnRescaseamountMonthly) ?>,
                            backgroundColor: 'rgba(255, 159, 64, 0.2)',
                            borderColor: 'rgb(255, 159, 64)',
                            borderWidth: 1
                            },{
                            label: 'Total Cases',
                            data: <?php echo json_encode($TotalcaseamountMonthly) ?>,
                            backgroundColor:'rgba(51, 153, 255, 0.2)',
                            borderColor: 'rgb(51, 153, 255)',
                            borderWidth: 1
                            }]
                        };

                        const configMultiLine = {
                            type: 'line',
                            data: dataMultiLine,
                            options: {
                            scales: {
                                y: {
                                beginAtZero: true
                                }
                            }
                            },
                        };

                        var myMultiLineChart = new Chart(
                            document.getElementById('myMonthlyMultiLineChart'),
                            configMultiLine
                        );
                    </script>
                    </div>
                </div>
            </div>
            <!-- Cases Chart End -->


            <!-- Recent Cases Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="casebox bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Recent Cases</h6>
                    </div>
                    <div class="casetable table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <tr class="tth text-dark">
                                <th scope="col">Case ID</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">Location</th>
                                <th scope="col">Status</th>
                                <th scope="col">Details</th>
                            </tr>
                            <tbody>
                                <?php include('cases1.php'); ?>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Recent Cases End -->

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

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    
</body>
</html>

