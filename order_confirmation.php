<?php
include('config/constants.php');

// Fetch the latest order from the database
$sql = "SELECT * FROM tbl_order ORDER BY order_id DESC LIMIT 1";
$result = $conn->query($sql);

$order = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .container {
            padding: 20px;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Order Confirmation</h2>
        <?php if ($order): ?>
            <table>
                <tr>
                    <th>Order ID</th>
                    <td><?php echo $order['order_id']; ?></td>
                </tr>
                <tr>
                    <th>Food Items</th>
                    <td><?php echo $order['food']; ?></td>
                </tr>
                <tr>
                    <th>Total Price</th>
                    <td>Rs <?php echo $order['total']; ?></td>
                </tr>
                <tr>
                    <th>Order Date</th>
                    <td><?php echo $order['order_date']; ?></td>
                </tr>
            </table>
            <div class="text-center">
                <a href="index.php" class="btn btn-primary">Back to Home</a>
            </div>
        <?php else: ?>
            <p>No order found.</p>
            <div class="text-center">
                <a href="index.php" class="btn btn-primary">Back to Home</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
