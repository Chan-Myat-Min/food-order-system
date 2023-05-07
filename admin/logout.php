<?php 
//include constants.php for SITEURL
include('../config/constants.php');

// 1. Destroyed the Session
session_destroy();

// 2 / Redirect to the login Page
header('location:'.SITEURL.'admin/login.php');
?>