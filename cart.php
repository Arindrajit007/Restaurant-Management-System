<?php include('config/constants.php');

// Check if the request is for adding an item to the cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name']) && isset($_POST['price']) && isset($_POST['quantity'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Check if the item already exists in the cart
    $checkQuery = "SELECT id, quantity FROM cart_items WHERE name = '$name'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        // Item exists, update the quantity
        $row = $checkResult->fetch_assoc();
        $existingQuantity = $row['quantity'];
        $newQuantity = $existingQuantity + $quantity;

        // Update the quantity for the existing item
        $updateQuery = "UPDATE cart_items SET quantity = '$newQuantity' WHERE name = '$name'";
        if ($conn->query($updateQuery) === TRUE) {
            echo "Item quantity updated in cart successfully";
        } else {
            echo "Error updating item quantity in cart: " . $conn->error;
        }
    } else {
        // Item does not exist, insert a new record
        $insertQuery = "INSERT INTO cart_items (name, price, quantity) VALUES ('$name', '$price', '$quantity')";
        if ($conn->query($insertQuery) === TRUE) {
            echo "Item added to cart successfully";
        } else {
            echo "Error adding item to cart: " . $conn->error;
        }
    }

} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'clear') {
    // Clear the cart_items table
    $sql = "DELETE FROM cart_items"; // This will delete all rows in the table
    "ALTER TABLE your_table_name AUTO_INCREMENT = 1";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error clearing cart'. $conn->error]);
    }
}

$conn->close();
?>
