<?php
    //Authorization
    //check whether the user is logged in or not
    if(!isset($_SESSION['user']))
    {
        //redirect to login page with message
        $_SESSION['no-login-msg'] = "<div style='color:red'>Please Login to Access Dashboard Panel</div>";
        //redirecting to the login page
        header('location:'.SITEURL.'login.php');
    }
?>