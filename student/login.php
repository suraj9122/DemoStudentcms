<?php
session_start();
include '../db/db_connect.php';

// Check if the student is already logged in
if (isset($_SESSION['student_id'])) {
    // Redirect to the dashboard if already logged in
    header('Location: dashboard.php');
    exit();
}

// Process login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the database to fetch student details based on email
    $query = "SELECT student_id, hashed_password FROM students WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['hashed_password'];

        // Verify the provided password with the hashed password
        if (password_verify($password, $hashedPassword)) {
            // Store student ID in session and redirect to the dashboard
            $_SESSION['student_id'] = $row['student_id'];
            header('Location: dashboard.php');
            exit();
        }
    }

    // If the login credentials are invalid, display an error message
    $loginError = "Invalid email or password. Please try again.";
}
?>





<!DOCTYPE html>
<html>
<head>
    <title>Student Login</title>
    <link rel="stylesheet" href="../CSS/styles.css">
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>

    html, body {
    height: 100%;
}

body {
    margin: 0;
    padding: 0;
    font-family: 'Roboto', sans-serif;
    background: rgb(2,0,36);
background: linear-gradient(169deg, rgba(2,0,36,1) 30%, rgba(9,44,121,1) 71%, rgba(3,184,172,1) 100%);
    background-repeat: no-repeat;
}
        .btn-primary {
            background-color: #00adb5;
            border-color: #00adb5;
        }
        .btn-primary:hover {
            background-color: #007f87;
            border-color: #007f87;
        }
        .login-form {
            background-color: #121212;
            margin-top: 20px;
            padding: 40px;
            border-radius: 5px;
            box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.3);
        }
        .login-form h2 {
            color: #00adb5;
            margin-bottom: 30px;
        }
        .login-form .form-group label {
            color: #fff;
        }
        .login-form .form-control {
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
                <form method="POST" action="" class="login-form">
                    <h2>Student Login</h2>
                    <?php if (isset($loginError)) { ?>
                        <div class="alert alert-danger"><?php echo $loginError; ?></div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                    <a href="../index.php" class="btn btn-secondary">Back to Home</a>
                </form>
                <p class="mt-3 text-center" style="color:aliceblue">Don't have an account? <a href="registration.php" style="color: #00adb5;">Register here</a></p>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS link -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
    <script src="../JS/scripts.js"></script>
</body>
</html>

