<?php include('config/constants.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the JSON data sent from the JavaScript fetch request
    $data = json_decode(file_get_contents("php://input"), true);

    // Extract city, state, and country from the JSON data
    $username = $data['username'];
    $city = $data['city'];
    $state = $data['state'];
    $country = $data['country'];

    // Validate and sanitize the data (you can add more validation/sanitization as needed)
    $city = htmlspecialchars(trim($city));
    $state = htmlspecialchars(trim($state));
    $country = htmlspecialchars(trim($country));

    // Assuming you have a database connection (replace with your actual database connection code)
    // Include your database connection code here
    // Example: include('db_connection.php');

    // Prepare and execute SQL statement to insert data into the database
    $sql = "UPDATE tbl_cus_login 
                SET City='$city', State='$state', Country='$country' 
                WHERE username='$username' AND password='$password'";

    if ($conn->query($sql) === TRUE) {
        echo "Location details saved successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>