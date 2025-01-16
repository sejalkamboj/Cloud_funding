<?php
// Database connection details
$host = 'localhost';
$user = 'root'; // Default username for localhost
$password = ''; // Default password for localhost
$dbname = 'fund_flow'; // Your database name

// Connect to the database
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$email = $_POST['email'];
$password = $_POST['password'];

// Query to check if the user exists
$sql = "SELECT * FROM users WHERE email = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Login success
    header("Location: payment.html"); // Redirect to the payment page
} else {
    // Login failed
    echo "<script>alert('Invalid email or password.'); window.history.back();</script>";
}

// Close connection
$stmt->close();
$conn->close();
?>
