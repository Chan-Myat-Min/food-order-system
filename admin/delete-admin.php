<?php
//include constants.php file here
include('../config/constants.php');
//1 get the ID  of admin to be deleted
$id = $_GET['id'];
//2. Create SQL Query to Delete Admin
$sql = "DELETE FROM tbl_admin WHERE id=$id";

//Execute the Query
$res = mysqli_query($conn, $sql);

// Check whether the Query executed successfully and Admin Deleted
if ($res == true) {
    //echo "Admin Deleted";
    // Query Executed Successfully and Admin Deleted

    //Create session variable to display message
    $_SESSION['delete'] = "Admin Deleted Successfully";

    // Redirect to the Manage Admin Page
    header('location:' . SITEURL . 'admin/manage-admin.php');

} else {
    //failed to delete admin
    //echo "failed to the admin ID";

    $_SESSION['delete'] = "Failed to Delete Admin. Try Again Later.";
    header('location:' . SITEURL . 'admin/manage-admin.php');
}
//3. Redirect to Manage Admin Page with message (success/error)
