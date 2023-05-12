<?php include "./partials/menu.php"; ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br /><br />
        <?php
        //Check whether the id is set or not
        if (isset($_GET['id'])) {
            //Get the Id and all other details
            // echo "Get the Data";

            $id = $_GET['id'];

            //Create SQL Query to get all other details
            $sql = "SELECT * FROM tbl_category WHERE id=$id";

            //Execute the Query
            $res = mysqli_query($conn, $sql);

            $count = mysqli_num_rows($res);

            if ($count == 1) {
                //echo "Helllo ";
                //Get all the data
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $current_image = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
            } else {
                //Redirect to the Manage category page with Session message
                $_SESSION['no-category-found'] = "<div class='error'>Category Not Found. </div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
                //echo "he is danger";
            }
        } else {
            //redirect to the Manage Category
            header('location:' . SITEURL . 'admin/manage-category.php');
            //echo "they are dg";
        }

        ?>

        <br /><br />


        <form action="" method="POST" enctype="multipart/form-data">
            <table class=" tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                        if ($current_image != "") {
                            //Display Image
                        ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?> " width="100px">
                        <?php
                        } else {
                            //Display Message
                            echo " <div class='error'>Image not Added </div>";
                        }
                        ?>

                    </td>
                </tr>

                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image">

                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if ($featured == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if ($featured == "No") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if ($active == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="Yes">Yes

                        <input <?php if ($active == "No") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class=" btn-secondary">
                    </td>
                </tr>


            </table>
        </form>
        <?php

        if (isset($_POST['submit'])) {
            //echo "Clicked";
            //1. Get all the values from our FORM
            $id = $_POST['id'];
            $title = $_POST['title'];
            $current_image = $_POST['current_image'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            //2. Updating New Image if selected
            //Check whether the image is selected or not
            if (isset($_FILES['image']['name'])) {
                //Get the Image Details
                $image_name = $_FILES['image']['name'];

                //Check whether the image is avalable or not
                if ($image_name != "") {
                    //Image Available
                    //Upload the New Image

                    //Auto Rename our Image
                    //GEt the extension of our image( img format aas jpg.png, etc) "specialfood1.jpg"
                    $ext = end(explode('.', $image_name));

                    //Rename the image
                    $image_name = "Food_Category_" . rand(000, 999) . '.' . $ext; // e.g. Food_Category_834.jpg

                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/category/" . $image_name;

                    //Finally upload the image
                    $upload = move_uploaded_file($source_path, $destination_path);

                    //Check whether the image is not 
                    //And if the image is not  uploaded then we will stop the process and redirect with error message
                    if ($upload == false) {

                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
                        header('location:' . SITEURL . 'admin/manage-category.php');

                        //STOp the Process
                        die();
                    }


                    //.B .Remove the Current Image if available
                    if ($current_image != "") {
                        $remove_path = "../images/category/" . $current_image;

                        $remove = unlink($remove_path);

                        //Check the whether the image is removed or not
                        //if Failed to remove then display message and stop the process
                        if ($remove == false) {
                            //failed to remove image
                            $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image.</div>";
                            header('location:' . SITEURL . 'admin/manage-category.php');
                            die();
                        }
                    }
                } else {
                    $image_name = $current_image;
                }
            } else {

                $image_name = $current_image;
            }


            //3. Update the Database
            $sql2 = "UPDATE tbl_category SET
                            title='$title',
                            image_name ='$image_name',
                            featured='$featured',
                            active ='$active'
                            WHERE id=$id
                            ";
            $res2 = mysqli_query($conn, $sql2);

            //4 Redirected to Manage Category Page with Message
            //Check whether executed or not
            if ($res2 == 2) {
                //Category Updated
                $_SESSION['update'] = "<div class='success'>Category Updated Successfully.</div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
            } else {
                //Failed to update category
                $_SESSION['update'] = "<div class='error'>Failed to Update Category.</div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
            }
        }

        ?>

    </div>
</div>

<?php include "./partials/footer.php"; ?>