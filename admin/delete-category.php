<?php
//Include Constrants File
include('../config/constants.php');

//echo "Delete Category";
//Check whether the id and image_name value is set or not
if (isset($_GET['id']) and isset($_GET['image_name']))
 {
    //get the value and Delete
    //echo "Get Value and Delete";
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //Remove the physical image file is available
    if ($image_name != "") 
    {
        //image is Available .so remove it
        $path = "../images/category/" . $image_name;
        //Remove  the image
        $remove = unlink($path);

        //If failed to remove then add an error message and stop the process
        if ($remove == false) {
            //Set the Session message
            $_SESSION['remove'] = "<div class='error'>Failed to remove category image</div>";
            //Redirect to the Manage Category Page
            header('location:' . SITEURL . 'admin/manage-category.php');
            //Stop the Process
            die();
        }
    }
    //Delete Data from Database
    //SQL  Query to Delete from DB
    $sql = "DELETE FROM tbl_category WHERE id=$id";

    //Execute the  Query
    $res = mysqli_query($conn, $sql);

    //Check whether the data is delete from database or not
    if ($res == true) {
        //Set Success Message and Redirect
        $_SESSION['delete'] = "<div class='success'>Category is Deleted Successfully...</div>";
        //Redirect to the Manage Category Page
        header('location:' . SITEURL . 'admin/manage-category.php');
    } else {
        //Set Fail Message and Redirect
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Category.</div>";

        //Redirect to the Manage Category Page
        header('location:' . SITEURL . 'admin/manage-category.php');
    }
} else
 {
    //redirect to Manage Categoty page
    header('location:' . SITEURL . 'admin/manage-category.php');
}
?>