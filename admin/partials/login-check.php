<?php 
// Authorization - Access Control
//Check whether the user is logged in or not
if(!isset($_SESSION['user'])) // if user session is not set
{
 //user is not loggedd in
 //Redirect to login page with message
 $_SESSION['no-login-message'] ="<div class='error'>Please login to access Admin Panel</div> ";
    //Redirect to  login Page
    header('location:'.SITEURL.'admin/login.php');
}

?>