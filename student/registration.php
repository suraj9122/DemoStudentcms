<?php
session_start();
include '../db/db_connect.php';

// Check if the student is already logged in
if (isset($_SESSION['student_id'])) {
    // Redirect to the dashboard if already logged in
    header('Location: dashboard.php');
    exit();
}

// Process registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $contactNumber = $_POST['contact_number'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $university = $_POST['university'];
    $password = $_POST['password'];

    // Hash the password before storing it in the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the student details into the database
    $query = "INSERT INTO students (first_name, last_name, contact_number, email, address, university, hashed_password) 
              VALUES ('$firstName', '$lastName', '$contactNumber', '$email', '$address', '$university', '$hashedPassword')";
    mysqli_query($conn, $query);

    // Redirect to the login page after successful registration
    header('Location: login.php');
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
    <link rel="stylesheet" href="../CSS/styles.css">
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background: rgb(2,0,36);
background: radial-gradient(circle, rgba(2,0,36,1) 30%, rgba(9,44,121,1) 71%, rgba(3,184,172,1) 100%);
            font-family: 'Roboto', sans-serif;
        }
        .btn-primary {
            background-color: #00adb5;
            border-color: #00adb5;
        }
        .btn-primary:hover {
            background-color: #007f87;
            border-color: #007f87;
        }
        .registration-form {
            background-color: #121212;
            padding: 40px;
            border-radius: 5px;
            box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.3);
        }
        .registration-form h2 {
            color: #00adb5;
            margin-bottom: 30px;
        }
        .registration-form .form-group label {
            color: #fff;
        }
        .registration-form .form-control {
            background-color: #1f1f1f;
            border: none;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="POST" action="" class="registration-form">
                    <h2>Student Registration</h2>
                    <div class="form-group">
                        <label for="first_name">First Name:</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name:</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                    <div class="form-group">
                        <label for="contact_number">Contact Number:</label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="university">University:</label>
                        <input type="text" class="form-control" id="university" name="university" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
                <p class="mt-3 text-center" style="color: #fff;">Already have an account? <a href="login.php" style="color: #00adb5;">Login here</a></p>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS link -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
    <script src="../JS/scripts.js"></script>
</body>
</html>
