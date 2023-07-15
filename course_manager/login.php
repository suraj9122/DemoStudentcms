<?php
session_start();
include '../db/db_connect.php';

// Check if the course manager is already logged in
if (isset($_SESSION['course_manager_id'])) {
    header('Location: dashboard.php');
    exit();
}

// Handle course manager login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['hashed_password'];

    // Check if the email exists in the database
    $checkEmailQuery = "SELECT * FROM course_managers WHERE email = '$email'";
    $checkEmailResult = mysqli_query($conn, $checkEmailQuery);

    if (mysqli_num_rows($checkEmailResult) === 1) {
        $courseManager = mysqli_fetch_assoc($checkEmailResult);

        // Verify the password
        if (password_verify($password, $courseManager['hashed_password'])) {
            // Set the course manager's ID in the session
            $_SESSION['course_manager_id'] = $courseManager['course_manager_id'];

            // Redirect to the dashboard
            header('Location: dashboard.php');
            exit();
        }
    }

    // Invalid email or password
    $error = "Invalid email or password. Please try again.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Course Manager Login</title>
    <link rel="stylesheet" href="../CSS/styles.css">
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background: rgb(0,0,0);
background: radial-gradient(circle, rgba(0,0,0,1) 23%, rgba(4,21,57,1) 87%, rgba(184,90,3,1) 100%);
            font-family: 'Roboto', sans-serif;
        }

        .container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background-color: #333333;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            color: #ffffff;
            transition: all 0.3s ease;
        }

        .container:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(255, 165, 0, 0.5);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #ff9900;
            transition: color 0.3s ease;
        }

        .container:hover h2 {
            color: #ffffff;
        }

        .form-group label {
            color: #ffffff;
        }

        .form-group input[type="email"],
        .form-group input[type="password"] {
            background-color: #555555;
            border: none;
            padding: 10px;
            color: #ffffff;
            transition: background-color 0.3s ease;
        }

        .form-group input[type="email"]:focus,
        .form-group input[type="password"]:focus {
            background-color: #777777;
        }

        .btn-primary {
            background-color: #ff9900;
            border: none;
            padding: 10px 20px;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #ff6600;
        }
        .btn-back {
            background-color:#a87c1d;
            color: #e0e0e0;
            border: none;
            padding: 10px 20px;
            margin-top: 20px;
            margin-right: 10px;
        }

        .btn-back:hover {
            background-color: #a8631d;
            color: #e0e0e0;
        }

        p {
            color: #ffffff;
            text-align: center;
            margin-top: 20px;
        }

        p a {
            color: #ff9900;
            transition: color 0.3s ease;
        }

        p a:hover {
            color: #ff6600;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Course Manager Login</h2>

        <?php if (isset($error)) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php } ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <a href="../index.php" class="btn btn-back">Back to Home</a>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>

    <!-- Include Bootstrap JS link -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
    <script src="../JS/scripts.js"></script>
</body>
</html>

