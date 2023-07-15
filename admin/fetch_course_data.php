<?php
include '../db/db_connect.php';

// Query the database to fetch the number of students in each course
$query = "SELECT courses.course_name, COUNT(enrollments.student_id) AS student_count
            FROM courses
            LEFT JOIN enrollments ON courses.course_id = enrollments.course_id
            GROUP BY courses.course_id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
