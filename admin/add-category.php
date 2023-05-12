<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1> Add Category</h1>

        <br /><br />


        <!-- Add Category Form Starts-->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>
                <tr>
                    <td>Select Image</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No

                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">

                    </td>
                </tr>
            </table>
        </form>
        <!-- Add Category Form Ends-->
        <?php
        //Check whether the submit button is clicked or not
        if (isset($_POST['submit'])) {
            // echo "clicked";
            //1. Get the value from Category FORM
            $title = $_POST['title'];

            // For Radio input, we need to check whether the button is selected or not
            if (isset($_POST['featured'])) {
                //Get the Value from FORM
                $featured = $_POST['featured'];
            } else {
                //Set the Default value
                $featured = "No";
            }
            if (isset($_POST['active'])) {
                $active = $_POST['active'];
            } else {
                $active = "No";
            }
            //check whether the image is selected or not and set the value for image name accordingly
            //print_r($_FILES['image']);

            // die(); //break the code here

            if (isset($_FILES['image']['name'])) {
                //upload the image
                //to upload image we need image name,source path and destination path
                $image_name = $_FILES['image']['name'];

                //Upload the Image only if image is selected
                if ($image_name != "")
                 {

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
                        header('location:' . SITEURL . 'admin/add-category.php');

                        //STOp the Process
                        die();
                    }
                }
            } else {
                // Don't upload the image and set the image_name value as blank
                $image_name = "";
            }

            //2. Creste SQ Query to Insert Categoty in Database 
            $sql = "INSERT INTO tbl_category SET
        title= '$title',
        image_name='$image_name',
        featured= '$featured',
        active= '$active'
        ";
            echo $sql;
            // 3. Execute the Query the Save in Database
            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            //4. Check whether the query executed or not and data added or not
            if ($res == true) {
                //Query Executed and Category Added
                $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
                // Redirect to the Manage Category Page
                header('location:' . SITEURL . 'admin/manage-category.php');
            } else {
                //failed to Add category
                $_SESSION['add'] = "<div class='error'>Failed to Add Category. </div>";
                // Redirect to the Manage Category Page
                header('location:' . SITEURL . 'admin/add-category.php');
            }
        }


        ?>

    </div>

</div>

<?php include('partials/footer.php'); ?>