<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Order</h1>

        <br /><br /><br />

        <?php 
            if(isset($_SESSION['update'])) {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
        ?>
        <br><br>

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Food</th>
                <th>Price</th>
                
                <th>Total</th>
                <th>Order Date</th>
                <th>Actions</th>
            </tr>

            <?php 
                // Get all the orders from database
                $sql = "SELECT * FROM tbl_order ORDER BY order_id DESC"; // Display the Latest Order at First
                // Execute Query
                $res = mysqli_query($conn, $sql);
                // Count the Rows
                $count = mysqli_num_rows($res);

                $sn = 1; // Create a Serial Number and set its initial value as 1

                if($count > 0) {
                    // Order Available
                    while($row = mysqli_fetch_assoc($res)) {
                        // Get all the order details
                        $order_id = $row['order_id'];
                        $food = $row['food'];
                        $price = $row['price'];
                        
                        $total = $row['total'];
                        $order_date = $row['order_date'];
            ?>

                        <tr>
                            <td><?php echo $sn++; ?>. </td>
                            <td><?php echo $food; ?></td>
                            <td><?php echo $price; ?></td>
                            
                            <td><?php echo $total; ?></td>
                            <td><?php echo $order_date; ?></td>
                            <td>
                                <a href="serve_order.php?order_id=<?php echo $order_id; ?>" class="btn-secondary">Serve Order</a>
                            </td>
                        </tr>

            <?php
                    }
                } else {
                    // Order not Available
                    echo "<tr><td colspan='7' class='error'>Orders not Available</td></tr>";
                }
            ?>
        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>
