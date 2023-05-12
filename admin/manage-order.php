<?php include "partials/menu.php"; ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Order</h1>
        <br /></br>
        <?php
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }


        ?>

        <a href="#" class=" btn-primary">Add Food</a>

        <br /><br />

        <table class=" tbl-full">
            <tr>
                <th>S.N </th>
                <th>Food</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>

            </tr>
            <?php
            //Get the orders from the DB
            $sql = "SELECT * FROM tbl_order ORDER BY id DESC "; //Next(late) add is  first see
            //Execute the Query
            $res = mysqli_query($conn, $sql);

            //Count the rows
            $count = mysqli_num_rows($res);

            $sn = 1; //Create a Serial number as value 1

            //Check
            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    //Order Available
                    $id = $row['id'];
                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $total = $row['total'];
                    $order_date = $row['order_date'];
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_email = $row['customer_email'];
                    $customer_address = $row['customer_address'];
            ?>

                    <tr>
                        <td><?= $sn++; ?></td>
                        <td><?= $food; ?> </td>
                        <td><?= $price; ?></td>
                        <td><?= $qty; ?></td>
                        <td><?= $total; ?></td>
                        <td><?= $order_date; ?></td>
                        <td><?= $status; ?></td>
                        <td><?= $customer_name; ?></td>
                        <td><?= $customer_contact; ?></td>
                        <td><?= $customer_email; ?></td>
                        <td><?= $customer_address; ?></td>

                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                            <a href="#" class="btn-danger">Delete Admin</a>

                        </td>

                    </tr>


            <?php
                }
            } else {
                //Order Not Available
                echo "<tr><td colspan='12'class='error'>Order Not Available.</td></td></tr>";
            }




            ?>



        </table>
    </div>
</div>

<?php include "partials/footer.php"; ?>