<?php
session_start();
include '../db/db_connect.php';

// Check if the admin is already logged in
if (isset($_SESSION['admin_id'])) {
    // Redirect to the dashboard if already logged in
    header('Location: dashboard.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Corrected field name

    // Check if the email already exists in the database
    $checkEmailQuery = "SELECT * FROM admins WHERE email = '$email'";
    $checkEmailResult = mysqli_query($conn, $checkEmailQuery);

    if (mysqli_num_rows($checkEmailResult) > 0) {
        $error = "Email already exists. Please choose a different email.";
    } else {
        // Insert the new course manager into the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insertQuery = "INSERT INTO admins (first_name, last_name, email, hashed_password) 
                        VALUES ('$firstName', '$lastName', '$email', '$hashedPassword')";
        mysqli_query($conn, $insertQuery);

        // Redirect to the login page with success message
        header('Location: admin_login.php?success=registration_successful');
        exit();
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Admin Registration</title>
    <link rel="stylesheet" href="../CSS/styles.css">
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f9f9f9;
        }

        .container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #3498db;
        }

        .form-group label {
            color: #333333;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"] {
            background-color: #b9cded;
            border: none;
            padding: 10px;
            color: #333333;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="email"]:focus,
        .form-group input[type="password"]:focus {
            background-color: #e0e0e0;
        }

        .btn-primary {
            background-color: #3498db;
            border: none;
            padding: 10px 20px;
            margin-top: 20px;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }
        .btn-back {
            background-color: #333333;
            color: #e0e0e0;
            border: none;
            padding: 10px 20px;
            margin-top: 20px;
            margin-right: 10px;
        }

        .btn-back:hover {
            background-color: #555555;
            color: #e0e0e0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Registration</h2>

        <form method="POST" action="">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
            <!-- <a href="#" class="btn btn-back">Back to Home</a> -->
        </form>
        <p class="mt-3 text-center" style="color: #2980b9;">Already have an account? <a href="admin_login.php" style="color: #00adb5;">Login here</a></p>
    </div>

    <!-- Include Bootstrap JS link -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
    <script src="../JS/scripts.js"></script>
</body>
</html>

