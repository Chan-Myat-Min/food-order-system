<?php include('partials-front/menu.php') ?>

<!-- CAtegories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods</h2>

        <?php
        //Display Categories that are actived
        $sql = "SELECT * FROM tbl_category WHERE active='Yes' ";

        //Execute the Query
        $res = mysqli_query($conn, $sql);

        //Count Rows
        $count = mysqli_num_rows($res);

        //Check whether foods are availavle or not
        if ($count > 0) {
            //food avalivale
            while ($row = mysqli_fetch_assoc($res)) {
                //Get the values

                $id = $row['id'];
                $title = $row['title'];
                $image_name = $row['image_name'];



        ?>

                <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                    <div class="box-3 float-container">
                        <?php
                        //Check whether image is available or not
                        if ($image_name == "") {
                            //Displayed Message
                            echo "<div class='error'>Image not available</div>";
                        } else {
                            //Image is Available
                        ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">

                        <?php

                        }
                        ?>


                        <h3 class="float-text text-white"><?php echo $title; ?></h3>
                    </div>
                </a>

        <?php
            }
        } else {
            //Categories Not Available
            echo "<div class='error'>Categories is not available.</div>";
        }


        ?>


        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->


<?php include('partials-front/footer.php'); ?>