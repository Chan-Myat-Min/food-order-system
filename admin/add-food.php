<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <?php

        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        ?>
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30 ">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the food">
                    </td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td><textarea name="description" cols="30" rows="5" placeholder="Description of the food."></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <?php
                            //Create PHP Code to display category grom database
                            //1. Create SQL to get all active categories from databases
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes' ";

                            //Executing Query
                            $res = mysqli_query($conn, $sql);

                            //Count Rows to check whether we have categories or not 
                            $count = mysqli_num_rows($res);

                            //if count is greater than Zero,we have categories else we donot have categories
                            if ($count > 0) {
                                //we have categories
                                while ($row = mysqli_fetch_assoc($res)) {
                                    //get the details of categories
                                    $id = $row['id'];
                                    $title = $row['title'];
                            ?>
                                    <option value="<?php echo $id; ?>"> <?php echo $title; ?></option>
                                <?php
                                }
                            } else {
                                //We donot have category
                                ?>
                                <option value="0">No Category found</option>
                            <?php

                            }

                            //2. Display on Dropdown
                            ?>


                        </select>
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
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>
        <?php

        //Check whether the button is clicked or not
        if (isset($_POST['submit'])) {

            //Add  the Food in Database
            //echo "Clicked";

            //1. Get the Data From FORM
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            $featured = "No"; //Setting the Default Value
            $active = "No"; // Setting the Default Value

            if (isset($_POST['featured'])) {
                $featured = $_POST['featured'];
            }

            if (isset($_POST['active'])) {
                $active = $_POST['active'];
            }
            //2. Upload the Image if Selected
            //Check whether the select image is clicked or not  upload the image only if the image is selected
            if (isset($_FILES['image']['name'])) {
                //Get the details of the selected image
                $image_name = $_FILES['image']['name'];

                //Check whether Image is selected or not and upload image only is selected
                if ($image_name != "") {
                    //Image is selected
                    //A. Rename the Iamge
                    //Get the extension  of the selected image ( image format...jpg)
                    $ext = end(explode('.', $image_name));

                    //Create New Name for image
                    $image_name = "Food-Name-" . rand(0000, 9999) . "." . $ext; // New Image Name May be "Food-Name-667.jpg"

                    //B. Upload the Image
                    //Get the src path and destination path

                    //Source path is the current location of the image
                    $src = $_FILES['image']['tmp_name'];

                    //Destination Path for the image to be uploaded
                    $dst = "../images/food/" . $image_name;

                    //Finally Uploaded the food Image
                    $upload = move_uploaded_file($src, $dst);

                    //Check whether image uploaded of not
                    if ($upload == false) {
                        //failed to uploaded the image
                        //Redirect to add FOod Page with error msg
                        $_SESSION['upload'] = "<div class='error'>Failed to upload Image.</div> ";
                        header('location:' . SITEURL . 'admin/add-food.php');

                        //Stop the Process
                        die();
                    }
                }
            } else {
                $image_name = ""; //Setting Default value is blank
            }

            //3. Insert into the Database

            //Create a SqL t o save or ADD FOOD
            //for  Number we do not need to pass value '' But for the String value is is compulsory is add quotes''
            $sql2 = "INSERT INTO tbl_food SET
            title ='$title',
            description ='$description',
            price= $price,
            image_name='$image_name',
            category_id=$category,
            featured='$featured',
            active='$active'
            ";
            //Execute the Query
            $res2 = mysqli_query($conn, $sql2);

            //Check whether data inserted or not
            if ($res == true) {
                //Data inserted Successfully
                // 4. Redirect  with Message to Manage Food Page
                $_SESSION['add'] = "<div class='success'>Food Added Successfully</div>";
                header('location:' . SITEURL . 'admin/manage-food.php');
            } else {
                $_SESSION['add'] = "<div class='error'>Failed to Add Food.</div>";
                header('location:' . SITEURL . 'admin/manage-food.php');
            }
        }

        ?>
    </div>

</div>

<?php include('partials/footer.php'); ?>