<?php include('config/constants.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CART</title>
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
  </style>
</head>
<body>
<?php 
    echo "<h2 class='text-center'>Cart</h2>" ;
    $query = "SELECT id, name, price FROM cart_items";
    $result = mysqli_query($conn, $query);
    $sql = "SELECT id, name, price, quantity FROM cart_items";
    $result = $conn->query($sql);

    $cartItems = [];
    $totalPrice = 0;

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $cartItems[] = $row;
            $totalPrice += $row['price'] * $row['quantity'] ;
        }
        echo "<table>";
        echo "<tr><th>Name</th><th>Price</th><th>Quantity</th><th>Total</th></tr>";

        foreach ($cartItems as $item) {
            echo "<tr>";
            echo "<td>" . $item['name'] . "</td>";
            echo "<td>Rs " . $item['price'] . "</td>";
            echo "<td>" . $item['quantity'] . "</td>";
            echo "<td>Rs " . ($item['price'] * $item['quantity']) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "<br>";
        echo "<p>Price: Rs " . $totalPrice . " X 18% GST</p>";
        echo "<p>Total Price: Rs " . ($totalPrice + ($totalPrice * 18 / 100)) . "</p>";
    } else {
        echo "Cart is empty";
    }
          
          // Closing the database connection
          
          
    
    mysqli_close($conn);
?>
    <!-- Cart Section Starts Here -->
    <section class="cart">
        <div class="container">
            
            <div id="cart-items"></div>
            <div id="cart-total" class="text-center"></div>
            <div class="text-center">
                <button id="clear-cart" class="btn btn-danger">Clear Cart</button>
                <button id="order" class="btn btn-success">Order</button> <!-- Added Order button -->
                <button id="print-cart" class="btn btn-primary">Order Details</button> <!-- Added Print button -->
            </div>
        </div>
    </section>
    <!-- Cart Section Ends Here -->

    <!-- JavaScript Section -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cartItemsContainer = document.getElementById('cart-items');
            const cartTotal = document.getElementById('cart-total');
            const clearCartButton = document.getElementById('clear-cart');
            const orderButton = document.getElementById('order');
            const printButton = document.getElementById('print-cart');

            clearCartButton.addEventListener('click', function () {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "cart.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        console.log(xhr.responseText);
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                cartItemsContainer.innerHTML = '';
                                cartTotal.innerText = 'Cart is empty';
                                alert('Cart cleared successfully');
                            } else {
                                alert('Error clearing cart: ' + response.message);
                            }
                        } catch (error) {
                            console.error('Error parsing JSON:', error);
                        }
                        if (xhr.status === 200) {
                            const response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                cartItemsContainer.innerHTML = '';
                                cartTotal.innerText = 'Cart is empty';
                                alert('Cart cleared successfully');
                            } else {
                                alert('Error clearing cart: ' + response.message);
                            }
                        } else {
                            alert('Error clearing cart');
                        }
                    }
                };
                xhr.send("action=clear");
            });

            orderButton.addEventListener('click', function () {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "order.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            const response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                alert('Order placed successfully');
                                window.location.href = 'order_confirmation.php';
                            } else {
                                alert('Error placing order: ' + response.message);
                            }
                        } else {
                            alert('Error placing order');
                        }
                    }
                };
                xhr.send();
            });

            printButton.addEventListener('click', function () {
                window.location.href = 'order_confirmation.php';
            });
        });

    </script>
</body>
</html>
