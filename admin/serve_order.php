<?php
include('../config/constants.php'); // Adjust the path as needed

if (isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']); // Ensure order_id is an integer

    // Fetch the order details from tbl_order using a prepared statement
    $sql = "SELECT * FROM tbl_order WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    if ($order) {
        $food = $order['food'];
        $price = $order['price'];
        $total = $order['total'];
        $order_date = $order['order_date'];

        // Insert the order details into tbl_served using a prepared statement
        $sql_insert = "INSERT INTO tbl_served (food, price, total, order_date) VALUES (?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param('sdds', $food, $price, $total, $order_date);
        if ($stmt_insert->execute()) {
            // Delete the order from tbl_order
            $sql_delete = "DELETE FROM tbl_order WHERE order_id = ?";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bind_param('i', $order_id);
            if ($stmt_delete->execute()) {
                $_SESSION['update'] = "<div class='success'>Order Served and Removed Successfully.</div>";
            } else {
                $_SESSION['update'] = "<div class='error'>Failed to Remove Order. Error: " . $stmt_delete->error . "</div>";
            }
        } else {
            $_SESSION['update'] = "<div class='error'>Failed to Serve Order. Error: " . $stmt_insert->error . "</div>";
        }
    } else {
        $_SESSION['update'] = "<div class='error'>Order Not Found.</div>";
    }

    // Redirect to manage order page
    header('location:' . SITEURL . 'admin/manage-order.php');
    exit();
} else {
    // Redirect to manage order page if no order_id is provided
    header('location:' . SITEURL . 'admin/manage-order.php');
    exit();
}
?>
