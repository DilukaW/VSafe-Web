<?php include "connection.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Vsafe</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Asap" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">

</head>
<body class="loginbody">
    <!-- Start - Background -->
    <div class="bg"></div>
    <div class="bg bg2"></div>
    <div class="bg bg3"></div>
    <div class="content">
    </div>
    <!-- End - Background -->
    <!--Start - Login Form -->
    <form class="login" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="row" style="margin-bottom: 30px;">
            <!-- Logo -->
            <div class="col-4">
                <img src="images/logo.png" alt="logo" style="width: 85px;">
            </div>
            <!-- Welcome Note -->
            <div class="col-8 align-bottom" style="font-weight: 900; font-size: 35px;">
                Welcome
            </div>
        </div>
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <button type="submit" name="submit">Login</button>
        <!--Login Failed massage -->
        <br>
        <?php
            if(isset($_SESSION['login']))
            {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
            if(isset($_SESSION['no-login-msg']))
            {
                echo $_SESSION['no-login-msg'];
                unset($_SESSION['no-login-msg']);
            }
        ?>
        <br>
    </form>
    <!--End - Login Form -->

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

  <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
<?php
    //Function to make the form unhackable
    function test_input($data) {
        $data = trim($data);    // removes the extra space, tab, newline from the user input
        $data = stripslashes($data);    // Remove backslashes (\) from the user input fields
        $data = htmlspecialchars($data); // Whouldn't alowe to enter scripts into the input fields
        return $data;
    }
    if(isset($_POST['submit']))
    {
        $username = test_input($_POST['username']); // saving the verified username to a variable
        $password = test_input($_POST['password']); // saving the verified password to a variable
        // 01. If the insert fields are empty giving the error message
        if($username == "" OR $password == ""){
            $_SESSION['login'] = "<div style='color:red'>Please Enter Both Username and Password</div>" ;
        }
        // 02. Check Whether the inserted username and password exist in the department table if yes redirect to the normal dashboard
        $sqlDepCheck = "SELECT * FROM tbl_department WHERE user_name='$username' AND password='$password'";
        $resDepCheck = mysqli_query($conn, $sqlDepCheck);
        $DepCount = mysqli_num_rows($resDepCheck);
        // 04. There is a existing user in department
        if($DepCount > 0)
        {
            $_SESSION['user'] = $username;
            $_SESSION['pwrd'] = $password;
            header('location:'.SITEURL.'dashboard.php');
        }
        else{  // 06. There isn't a user in the admin table
            $_SESSION['login'] = "<div style='color:red'>Username or Password incorrect</div>" ;
        }
    }
?>