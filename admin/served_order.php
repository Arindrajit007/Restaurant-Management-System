<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Served Orders</h1>
        <br /><br /><br />

        <?php 
            $sql = "SELECT * FROM tbl_served ORDER BY id DESC";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
        ?>

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Food</th>
                <th>Price</th>
                <th>Total</th>
                <th>Order Date</th>
            </tr>

            <?php 
                if ($count > 0) {
                    $sn = 1;
                    while ($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
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
            </tr>

            <?php
                    }
                } else {
                    echo "<tr><td colspan='5' class='error'>No Served Orders Found</td></tr>";
                }
            ?>
        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>
