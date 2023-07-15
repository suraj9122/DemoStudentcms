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
    $email = $_POST['email'];
    $password = $_POST['password']; // Corrected field name

    // Query the database to fetch the admin details by email
    $query = "SELECT * FROM admins WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['hashed_password'];

        // Verify the provided password with the stored hashed password
        if (password_verify($password, $hashedPassword)) {
            // Set the admin ID in the session
            $_SESSION['admin_id'] = $row['admin_id'];

            // Redirect to the dashboard
            header('Location: dashboard.php');
            exit();
        }
    }

    // If the login credentials are invalid, display an error message
    $error = "Invalid email or password.";
}
?>





<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
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
    background-repeat: no-repeat;
            background: rgb(58,59,180);
background: linear-gradient(74deg, rgba(58,59,180,1) 21%, rgba(253,125,29,1) 60%, rgba(252,176,69,1) 100%);
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

        .form-group input[type="email"],
        .form-group input[type="password"] {
            background-color: #b9cded;
            border: none;
            padding: 10px;
            color: #333333;
        }

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

        p {
            text-align: center;
            margin-top: 20px;
            color: #aaaaaa;
        }

        p a {
            color: #3498db;
        }
    
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Login</h2>

        <?php if (isset($error)) { ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
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
        <p>Don't have an account? <a href="admin_register.php">Register here</a></p>
    </div>

    <!-- Include Bootstrap JS link -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
    <script src="../JS/scripts.js"></script>
</body>
</html>

