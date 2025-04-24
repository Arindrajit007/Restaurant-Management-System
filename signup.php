<?php include('config/constants.php');
if ($_SERVER["REQUEST_METHOD"] == "POST" &&
!empty($_POST['signup-name']) &&
!empty($_POST['signup-username']) &&
!empty($_POST['signup-password']) &&
!empty($_POST['signup-city']) &&
!empty($_POST['signup-state']) &&
!empty($_POST['signup-country']) &&
!empty($_POST['signup-phone']) &&
!empty($_POST['signup-email'])) {

// Get the form data
$name = $_POST['signup-name'];
$username = $_POST['signup-username'];
$password = $_POST['signup-password'];
$city = $_POST['signup-city'];
$state = $_POST['signup-state'];
$country = $_POST['signup-country'];
$phone = $_POST['signup-phone'];
$email = $_POST['signup-email'];

// Hash the password for security
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Prepare and bind the SQL statement to insert data into the table
$stmt = $conn->prepare("INSERT INTO tbl_cus_login (Name, username, password, City, State, Country, Phone, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss", $name, $username, $hashed_password, $city, $state, $country, $phone, $email);

// Execute the statement
if ($stmt->execute()) {
    echo "Signup successful!";
    header('Location: login.html');
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
} else {
echo "All fields are required!";
}
?>