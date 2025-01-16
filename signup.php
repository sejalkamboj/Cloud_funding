<?php
$error_message = '';
$success_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password']; // The plain password from the form

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'fund_flow');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the email already exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If email already exists, store the error message
        $error_message = "Email is already registered!";
    } else {
        // Insert the user data into the database
        $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $password);

        if ($stmt->execute()) {
            // Success message
            $success_message = "<h3>Sign-up successful! You can now. </h3>";
        } else {
            // Error during insertion
            $error_message = "Error: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fund Flow - Sign Up</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <img src="fund-flow-logo.png" alt="Fund Flow Logo" class="login-logo">
                <h2>Create an Account</h2>
            </div>

            <!-- Display success or error message -->
            <?php if ($error_message): ?>
                <div class="error-message" style="color: red; font-size: 0.9em; margin-bottom: 10px;">
                    <?php echo $error_message; ?>
                </div>
            <?php elseif ($success_message): ?>
                <div class="success-message" style="color: green; font-size: 0.9em; margin-bottom: 10px;">
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <!-- Signup Form -->
            <form action="signup.php" method="POST">
                <div class="input-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required value="<?php echo isset($email) ? $email : ''; ?>">
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <div class="input-group">
                    <button type="submit" class="login-btn">Sign Up</button>
                </div>

                <div class="login-footer">
                    <p>Already have an account? <a href="login.html">Login here</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
