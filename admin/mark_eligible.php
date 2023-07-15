<!-- mark_eligible.php -->

<?php
include '../db/db_connect.php';

// Get the selected student IDs
$studentIds = json_decode($_POST['student_ids']);

// Update the graduated column for selected students
$query = "UPDATE students SET graduated = 1 WHERE student_id IN (" . implode(',', $studentIds) . ")";
mysqli_query($conn, $query);
?>
