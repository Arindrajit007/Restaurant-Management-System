<?php
include('config/constants.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Create SQL select statement to check credentials
    $sql = "SELECT * FROM tbl_cus_login WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        // Verify the hashed password
        if (password_verify($password, $row['password'])) {
            // Check if city, state, and country are blank
            if (empty($row['City']) && empty($row['State']) && empty($row['Country'])) {
                // Redirect to location.html
                header('Location: location.html');
                exit;
            } else {
                // Redirect to index.php
                header('Location: index.php');
                exit;
            }
        } else {
            echo "Invalid username or password";
        }
    } else {
        echo "Invalid username or password";
    }

    // Close connection
    mysqli_close($conn);
}
?>
