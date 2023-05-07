<?php
include('partials/menu.php');
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br /><br/>
        <?php
        if(isset($_SESSION['add'])) //check whether session is set or not
        {
            echo $_SESSION['add']; // display session msg
            unset($_SESSION['add']); //Remove session msg
        }
        ?>

        <form action="" method="POST">
            <table class=" tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Your Name">
                    </td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" placeholder="Your Username">
                    </td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td>
                        <input type="password" name="password" placeholder="Your Password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class=" btn-secondary">
                    </td>
                </tr>
            </table>

        </form>

    </div>
</div>

<?php
include ("partials/footer.php"); ?>
<?php
// processs the value from Form and Save it in DB

//Check whether the submit buttom is clicked or not


if (isset($_POST['submit'])) {
    //Button Clicked
    //echo "Button Clicked";

    //1. Get the Data from Form
    $full_name = $_POST["full_name"];
    $username = $_POST["username"];
    $password = md5($_POST["password"]);

    //2.SQL Query to Save the data into database
    $sql = "INSERT INTO tbl_admin SET
            full_name='$full_name',
            username='$username',
            password='$password'  
             ";
    // echo $sql;
    //3. Executing Query and Saving Data into Data
    // $conn =mysqli_connect('localhost','root','') or die(mysqli_error()); //Database Connection

    // $db_select = mysqli_select_db($conn,'food-order') or die(mysqli_error()); // Selecthing DB
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    // 4. Check whether the (Query is Executed) data is inserted or not and display appropriate message
    if ($res == true) {
        //Data Inserted
        // echo "Data Inserted";
        //Create a Session Variable to Display Message
        $_SESSION['add'] = "Admin Added Successfully";
        //Redirect Page to ADD admin

        header("location:" . SITEURL . 'admin/manage-admin.php');
    } else {
        //echo "Fail to inserted data";

        //Create a Session Variable to Display Message
        $_SESSION['add'] = "Failed to Add Admin";
        //             // Redirect Page to ADD admin
        header("location:" . SITEURL . 'admin/manage-admin.php');
    }

    // 
}


?>