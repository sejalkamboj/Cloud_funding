<?php
$email = $_POST['email'];
$password = $_POST['password']; // The plain password entered by the user
$error_message = '';

// Database connection
$conn = new mysqli('localhost', 'root', '', 'fund_flow');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement to retrieve the user data
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists in the database
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc(); // Fetch user data

    // Compare the entered password with the stored password (plain text)
    if ($password == $user['password']) {
        // Redirect to payment page if login is successful
        header('Location: payment.html');
        exit();
    } else {
        // Incorrect password
        $error_message = "Invalid password. Please try again.";
    }
} else {
    // Email not found in the database
    $error_message = "No account found with this email. Please check the email or sign up.";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fund Flow - Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <img src="fund-flow-logo.png" alt="Fund Flow Logo" class="login-logo" >
                <h2>Login to Fund Flow</h2>
            </div>

            <form action="store_login.php" method="POST">
                <div class="input-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <?php if ($error_message): ?>
                    <div class="error-message" style="color: red; font-size: 0.9em; margin-top: 10px;">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <div class="input-group">
                    <button type="submit" class="login-btn">Login</button>
                </div>

                <div class="login-footer">
                    <p>Don't have an account? <a href="signup.html">Sign up</a></p>
                    <p><a href="#">Forgot your password?</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
