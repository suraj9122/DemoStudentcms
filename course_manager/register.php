<?php
session_start();
include '../db/db_connect.php';

// Check if the course manager is already logged in
if (isset($_SESSION['course_manager_id'])) {
    header('Location: dashboard.php');
    exit();
}

// Handle course manager registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['hashed_password'];

    // Check if the email already exists in the database
    $checkEmailQuery = "SELECT * FROM course_managers WHERE email = '$email'";
    $checkEmailResult = mysqli_query($conn, $checkEmailQuery);

    if (mysqli_num_rows($checkEmailResult) > 0) {
        $error = "Email already exists. Please choose a different email.";
    } else {
        // Insert the new course manager into the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insertQuery = "INSERT INTO course_managers (first_name, last_name, email, hashed_password) 
                        VALUES ('$firstName', '$lastName', '$email', '$hashedPassword')";
        mysqli_query($conn, $insertQuery);

        // Redirect to the login page with success message
        header('Location: login.php?success=registration_successful');
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Course Manager Registration</title>
    <link rel="stylesheet" href="../CSS/styles.css">
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #000000;
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

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"] {
            background-color: #555555;
            border: none;
            padding: 10px;
            color: #ffffff;
            transition: background-color 0.3s ease;
        }

        .form-group input[type="text"]:focus,
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Course Manager Registration</h2>

        <?php if (isset($error)) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php } ?>

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
        </form>
    </div>

    <!-- Include Bootstrap JS link -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
    <script src="../JS/scripts.js"></script>
</body>
</html>

