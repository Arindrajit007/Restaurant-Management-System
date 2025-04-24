<?php
session_start();
include('config/constants.php');

// Fetch cart items from the database
$sql = "SELECT name, price, quantity FROM cart_items";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $orderDate = date('Y-m-d H:i:s');
    $foodItems = [];
    $totalPrice = 0;

    while ($row = $result->fetch_assoc()) {
        $foodName = $row['name'];
        $price = $row['price'];
        $quantity = $row['quantity'];
        $total = $price * $quantity;

        $foodItems[] = $foodName . ' (' . $quantity . ')';
        $totalPrice += $total;
    }

    $foods = implode(', ', $foodItems);
    $totalPriceWithGST = $totalPrice + ($totalPrice * 18 / 100);

    $insertOrder = "INSERT INTO tbl_order (food, price, total, order_date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertOrder);
    $stmt->bind_param('sdds', $foods, $totalPrice, $totalPriceWithGST, $orderDate);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error placing order: ' . $stmt->error]);
    }

    // Clear cart items after placing the order
    $clearCart = "DELETE FROM cart_items";
    $conn->query($clearCart);
} else {
    echo json_encode(['success' => false, 'message' => 'Cart is empty']);
}

$conn->close();
?>
