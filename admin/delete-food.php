<?php
//imclude constants Page
include('../config/constants.php');

//echo " Delete Food Page";

if (isset($_GET['id']) && isset($_GET['image_name']))  // you can also use AND as &&

{

    //process to Delete
    //echo "PRocess to delete0";

    //1. Get ID and image name
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //2. Remove the image if available
    //Check whether the image is available or not and Delete only if available
    if ($image_name != "") {
        //it has image and need to remove from folder
        //Get the image path
        $path = "../images/food/" . $image_name;

        //Remove Image file from folder
        $remove = unlink($path);

        //Check whether the image is removed or not
        if ($remove == false) {
            //Failed to Remove image
            $_SESSION['upload'] = "<div class='error'>Failed to Remove Image file. </div>";
            header('location:' . SITEURL . 'admin/manage-food.php');
            die();
        }
    }
    //3. Delete Food from Database
    $sql = "DELETE FROM tbl_food WHERE id=$id";

    //Execute Query
    $res = mysqli_query($conn, $sql);

    //Check whether Query executed or not and set the session msg respectively
    if ($res == true) {
        //Food Deleted
        $_SESSION['delete'] = "<div class='success'>Food Delete Successfully.</div>";
        header('location:' . SITEURL . 'admin/manage-food.php');
    } else {
        //Failed to  Deleting food
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Food.</div>";
        header('location:' . SITEURL . 'admin/manage-food.php');
    }
    //4. Redirect to the Manage Page with Session Msg

} else {
    //Redirect to Manage Food Page
    //echo "Redirect";
    $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access.</div>";
    header('location:' . SITEURL . 'admin/manage-food.php');
}
