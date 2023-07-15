<?php
session_start();
include '../db/db_connect.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}

// Check if the request contains the necessary data
if (isset($_POST['studentId']) && isset($_POST['courseId'])) {
    $studentId = $_POST['studentId'];
    $courseId = $_POST['courseId'];

    // Fetch the student and course details from the database
    $query = "SELECT students.student_id, students.first_name, students.last_name, courses.course_id, courses.course_name, courses.price
              FROM students
              INNER JOIN enrollments ON students.student_id = enrollments.student_id
              INNER JOIN courses ON enrollments.course_id = courses.course_id
              WHERE students.student_id = $studentId AND courses.course_id = $courseId
              LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        $graduateId = ''; // Auto-incremented in the database
        $studentId = $row['student_id'];
        $firstName = $row['first_name'];
        $lastName = $row['last_name'];
        $courseId = $row['course_id'];
        $courseName = $row['course_name'];
        $coursePrice = $row['price'];
        $graduateStatus = 'Graduate';

        // Insert the data into the graduates table
        $insertQuery = "INSERT INTO graduates (graduate_id, student_id, first_name, last_name, course_id, course_name, course_price, graduate)
                        VALUES (NULL, $studentId, '$firstName', '$lastName', $courseId, '$courseName', $coursePrice, '$graduateStatus')";
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            // Update the graduate status to 'Graduate' in the students table
            $updateQuery = "UPDATE students SET graduated = 1 WHERE student_id = $studentId";
            $updateResult = mysqli_query($conn, $updateQuery);

            if ($updateResult) {
                $response = array('status' => 'success');
                echo json_encode($response);
            } else {
                $response = array('status' => 'error');
                echo json_encode($response);
            }
        } else {
            $response = array('status' => 'error');
            echo json_encode($response);
        }
    } else {
        $response = array('status' => 'error');
        echo json_encode($response);
    }
} else {
    $response = array('status' => 'error');
    echo json_encode($response);
}
?>
