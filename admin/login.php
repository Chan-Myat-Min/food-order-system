<?php include('../config/constants.php');?>
<html>

<head>
    <title class="text-center">Login Form</title>
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
</head>

<body>

    <div class="log">
        
        <br><br>
        <form class="login" method="POST" action="">
            <h2 class="text-center">Login Page</h2><br><br/>
            
            <?php
        if(isset($_SESSION['login']))
        {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        if(isset($_SESSION['no-login-message']))
        {
            echo $_SESSION['no-login-message'];
            unset($_SESSION['no-login-message']);
        }
        ?>

            <br>
            <label><b>User Name
                </b>
            </label>
            <input type="text" name="username" class="Uname" placeholder="Username">
            <br><br>
            <label><b>Password
                </b>
            </label>
            <input type="password" name="password" class="Pass" placeholder="Password">
            <br><br/><br/>
            <input type="submit" name="submit" class="btn-login" value="Log In Here">
            <br><br>

            <br><br>
             <a href="#" class="">Forget Password</a>
        </form>
    </div>

</body>

</html>
<br/><br/>
<?php 
if(isset($_POST['submit']))
{
//process for login
//1.Get the Data from login form

 echo $username =$_POST['username'];
 echo $password =md5($_POST['password']);

 //2. SQL to check whether the user with username and password exists or not
 $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

 //3. Execute the Query 
 $res = mysqli_query($conn, $sql);
 
 //4.  Count rows to check whether the user exists or not
 $count= mysqli_num_rows($res);

 if($count==1)
 {
    $_SESSION['login'] ="<div class='success'>Login is Successfully.</div>" ;
    $_SESSION['user'] = $username; // To Check whether the user is logged in or not and logout will unset it

     //Redirect to the Home Page/DashBoard
    header('location:'.SITEURL.'admin/');
 }else{
    //USer Not Available and Login Fail
    $_SESSION['login'] = "<div class='error'>Username or Password did not match</div>";
  
    header('location:'.SITEURL.'admin/login.php');
    
 }



}
?>