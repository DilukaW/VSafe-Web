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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart Js script -->
    <title>analytics - VSafe</title>

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
    <!-- Multiple Bar Chart -->

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

            <!-- Chart Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <!--Line Chart php code-->
                <?php 
                $qrylinechart = "SELECT MONTH(date_time) AS Month, COUNT(id) AS Number_of_Cases FROM `tbl_case` group by MONTH(date_time)";
                $res = mysqli_query($conn, $qrylinechart);
                    
                foreach($res as $data)
                {
                    $realMonth[] = ["January","February","March","April","May","June","July","september","October","November","December"];
                    switch($data['Month']){
                            case 1: $real = "January";break;
                            case 2: $real = "February";break;
                            case 3: $real = "March";break;
                            case 4: $real = "April";break;
                            case 5: $real = "May";break;
                            case 6: $real = "June"; break;
                            case 7: $real = "July"; break;
                            case 8: $real = "August"; break;
                            case 9: $real = "September"; break;
                            case 10: $real = "October"; break;
                            case 11: $real = "November"; break;
                            case 12: $real = "December"; break; 
                    }
                    $monthLine[] = $real;
                    $caseamountLine[] = $data['Number_of_Cases'];
                }

                ?>
                    <div class="col-sm-12 col-xl-6">
                        <div class="casebox bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Single Line Chart</h6>
                            <canvas id="myLineChart"></canvas>
                        </div>
                    </div>
                    <!--Script for the line chart-->
                    <script>
                        const labelsLine = <?php echo json_encode($monthLine) ?>;
                        const dataLine = {
                        labels: labelsLine,
                        datasets: [{
                            label: 'Number of Accidents per Month',
                            data: <?php echo json_encode($caseamountLine) ?>,
                            backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(201, 203, 207, 0.2)'
                            ],
                            borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)'
                            ],
                            borderWidth: 1
                        }]
                        };

                        const configLine = {
                        type: 'line',
                        data: dataLine,
                        options: {
                            scales: {
                            y: {
                                beginAtZero: true
                            }
                            }
                        },
                        };

                        var myLineChart = new Chart(
                        document.getElementById('myLineChart'),
                        configLine
                        );
                        </script>
                    <!-- MultiLine Chart php -->
                    <?php 
                        $sqlMultiLine = "SELECT
                                    MONTH(date_time) AS Month,
                                    COUNT(case when status=1 then 1 end) AS Resolved,
                                    COUNT(case when status=0 then 1 end) AS UnResolved,
                                    COUNT(*) as Total_Cases
                                FROM tbl_case
                                GROUP BY Month(date_time);";
                        $res = mysqli_query($conn, $sqlMultiLine);
                    foreach($res as $data)
                    {
                        switch($data['Month']){
                        case 1: $monthMultiLine[] = "January";break;
                        case 2: $monthMultiLine[] = "February";break;
                        case 3: $monthMultiLine[] = "March";break;
                        case 4: $monthMultiLine[] = "April";break;
                        case 5: $monthMultiLine[] = "May";break;
                        case 6: $monthMultiLine[] = "June"; break;
                        case 7: $monthMultiLine[] = "July"; break;
                        case 8: $monthMultiLine[] = "August"; break;
                        case 9: $monthMultiLine[] = "September"; break;
                        case 10: $monthMultiLine[] = "October"; break;
                        case 11: $monthMultiLine[] = "November"; break;
                        case 12: $monthMultiLine[] = "December"; break; 
                        }
                        $RescaseamountMultiLine[] = $data['Resolved'];
                        $UnRescaseamountMultiLine[] = $data['UnResolved'];
                        $TotalcaseamountMultiLine[] = $data['Total_Cases'];
                    }
                    ?>
                    <div class="col-sm-12 col-xl-6">
                        <div class="casebox bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Multi Line Chart</h6>
                            <canvas id="myMultiLineChart"></canvas>
                        </div>
                    </div>
                    <!-- MultiLine Chart Script -->
                    <script>
                        const labelsMultiLine = <?php echo json_encode($monthMultiLine) ?>;
                        const dataMultiLine = {
                            labels: labelsMultiLine,
                            datasets: [{
                            label: 'Resolved Cases',
                            data: <?php echo json_encode($RescaseamountMultiLine) ?>,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgb(255, 99, 132)',
                            borderWidth: 1
                            },{
                            label: 'UnResolved Cases',
                            data: <?php echo json_encode($UnRescaseamountMultiLine) ?>,
                            backgroundColor: 'rgba(255, 159, 64, 0.2)',
                            borderColor: 'rgb(255, 159, 64)',
                            borderWidth: 1
                            },{
                            label: 'Total Cases',
                            data: <?php echo json_encode($TotalcaseamountMultiLine) ?>,
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
                            document.getElementById('myMultiLineChart'),
                            configMultiLine
                        );
                    </script>
                    <!--Bar chart php-->
                        
                    <?php
                    $qryBarchart = "SELECT MONTH(date_time) AS Month, COUNT(id) AS Number_of_Cases FROM `tbl_case` group by MONTH(date_time)";
                    $res = mysqli_query($conn, $qryBarchart);
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
                          $caseamount[] = $data['Number_of_Cases'];
                    }

                    ?>

                    <div class="col-sm-12 col-xl-6">
                        <div class="casebox bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Single Bar Chart</h6>
                            <canvas id="myBarChart"></canvas>    <!--bar-chart-->
                        </div>
                    </div>
                    <!--Bar chart script-->
                    
                    <script>
                    const labels = <?php echo json_encode($month) ?>;
                    const data = {
                        labels: labels,
                        datasets: [{
                        label: 'Number of Accidents per Month',
                        data: <?php echo json_encode($caseamount) ?>,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(201, 203, 207, 0.2)'
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)'
                        ],
                        borderWidth: 1
                        }]
                    };

                    const config = {
                        type: 'bar',
                        data: data,
                        options: {
                        scales: {
                            y: {
                            beginAtZero: true
                            }
                        }
                        },
                    };

                    var myBarChart = new Chart(
                        document.getElementById('myBarChart'),
                        config
                    );
                    </script>
                    <!-- MultiBar Chart php -->
                    <?php 
                    $sqlMultiBar = "SELECT
                                MONTH(date_time) AS Month,
                                COUNT(case when status=1 then 1 end) AS Resolved,
                                COUNT(case when status=0 then 1 end) AS UnResolved,
                                COUNT(*) as Total_Cases
                            FROM tbl_case
                            GROUP BY Month(date_time);";
                    $res = mysqli_query($conn, $sqlMultiBar);
                foreach($res as $data)
                {
                    switch($data['Month']){
                    case 1: $monthMultiBar[] = "January";break;
                    case 2: $monthMultiBar[] = "February";break;
                    case 3: $monthMultiBar[] = "March";break;
                    case 4: $monthMultiBar[] = "April";break;
                    case 5: $monthMultiBar[] = "May";break;
                    case 6: $monthMultiBar[] = "June"; break;
                    case 7: $monthMultiBar[] = "July"; break;
                    case 8: $monthMultiBar[] = "August"; break;
                    case 9: $monthMultiBar[] = "September"; break;
                    case 10: $monthMultiBar[] = "October"; break;
                    case 11: $monthMultiBar[] = "November"; break;
                    case 12: $monthMultiBar[] = "December"; break; 
                    }
                    $Rescaseamount[] = $data['Resolved'];
                    $UnRescaseamount[] = $data['UnResolved'];
                    $Totalcaseamount[] = $data['Total_Cases'];
                }
                ?>

                    <div class="col-sm-12 col-xl-6">
                        <div class="casebox bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Multiple Bar Chart</h6>
                            <canvas id="myMultiBarChart"></canvas>
                        </div>
                    </div>
                    <!-- MultiBar Chart Script -->
                    <script>
                        const labelsMultiBar = <?php echo json_encode($monthMultiBar) ?>;
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
                            document.getElementById('myMultiBarChart'),
                            configMultiBar
                        );
                    </script>

                    <!--Pie Chart php-->
                    
                    <?php 
                    $qryPiechart = "SELECT MONTH(date_time) AS Month, COUNT(id) AS Number_of_Cases FROM `tbl_case` group by MONTH(date_time)";
                        $resPie = mysqli_query($conn, $qryPiechart);
                    foreach($resPie as $dataPie)
                    {
                        switch($dataPie['Month']){
                        case 1: $monthPie[] = "January";break;
                        case 2: $monthPie[] = "February";break;
                        case 3: $monthPie[] = "March";break;
                        case 4: $monthPie[] = "April";break;
                        case 5: $monthPie[] = "May";break;
                        case 6: $monthPie[] = "June"; break;
                        case 7: $monthPie[] = "July"; break;
                        case 8: $monthPie[] = "August"; break;
                        case 9: $monthPie[] = "September"; break;
                        case 10: $monthPie[] = "October"; break;
                        case 11: $monthPie[] = "November"; break;
                        case 12: $monthPie[] = "December"; break; 
                        }
                        $caseamountPie[] = $dataPie['Number_of_Cases'];
                    }

                    ?>
                    <div class="col-sm-12 col-xl-6">
                        <div class="casebox bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Pie Chart</h6>
                            <canvas id="myPieChart"></canvas>
                        </div>
                    </div>
                    <!-- Pie Chart Script -->
                    
                    <script>
                    const labelsPie = <?php echo json_encode($monthPie) ?>;
                    const dataPie = {
                        labels: labelsPie,
                        datasets: [{
                        label: 'Number of Accidents per Month',
                        data: <?php echo json_encode($caseamountPie) ?>,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(201, 203, 207, 0.2)'
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)'
                        ],
                        borderWidth: 1
                        }]
                    };

                    const configPie = {
                        type: 'pie',
                        data: dataPie,
                    };

                    var myPieChart = new Chart(
                        document.getElementById('myPieChart'),
                        configPie
                    );
                    </script>

                    <!--Doughnut Chart php-->
                    <?php 
                    $qryDoughchart = "SELECT MONTH(date_time) AS Month, COUNT(id) AS Number_of_Cases FROM `tbl_case` group by MONTH(date_time)";
                        $res = mysqli_query($conn, $qryDoughchart);
                    foreach($res as $data)
                    {
                        switch($data['Month']){
                        case 1: $monthDough[] = "January";break;
                        case 2: $monthDough[] = "February";break;
                        case 3: $monthDough[] = "March";break;
                        case 4: $monthDough[] = "April";break;
                        case 5: $monthDough[] = "May";break;
                        case 6: $monthDough[] = "June"; break;
                        case 7: $monthDough[] = "July"; break;
                        case 8: $monthDough[] = "August"; break;
                        case 9: $monthDough[] = "September"; break;
                        case 10: $monthDough[] = "October"; break;
                        case 11: $monthDough[] = "November"; break;
                        case 12: $monthDough[] = "December"; break; 
                        }
                        $caseamountDough[] = $data['Number_of_Cases'];
                    }

                    ?>
                    <div class="col-sm-12 col-xl-6">
                        <div class="casebox bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Doughnut Chart</h6>
                            <canvas id="myDoughnutChart"></canvas>
                        </div>
                    </div>

                    <!-- Doughnut Chart Script -->
                    <script>
                        const labelsDough = <?php echo json_encode($monthDough) ?>;
                        const dataDough = {
                            labels: labelsDough,
                            datasets: [{
                            label: 'Number of Accidents per Month',
                            data: <?php echo json_encode($caseamountDough) ?>,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 205, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(201, 203, 207, 0.2)'
                            ],
                            borderColor: [
                                'rgb(255, 99, 132)',
                                'rgb(255, 159, 64)',
                                'rgb(255, 205, 86)',
                                'rgb(75, 192, 192)',
                                'rgb(54, 162, 235)',
                                'rgb(153, 102, 255)',
                                'rgb(201, 203, 207)'
                            ],
                            borderWidth: 1
                            }]
                        };

                        const configDough = {
                            type: 'doughnut',
                            data: dataDough,
                        };

                        var myDoughnutChart = new Chart(
                            document.getElementById('myDoughnutChart'),
                            configDough
                        );
                    </script>

                </div>
            </div>
            <!-- Chart End -->

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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> <!-- Google Charts -->
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