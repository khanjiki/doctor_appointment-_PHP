<?php
include 'database.php' ; // database connection
include 'DoctorAvailability.php'; //include the class
session_start();
$doctor_id = $_SESSION['user_id'];
if($_SERVER['REQUEST_METHOD'] == 'post'){
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time =$_POST['end_time'];
$database = new Database();
$db = $database->connection();
$availability = new DoctorAvailability($db);
if ($availability($doctor_id, $date, $start_time ,$end_time)){
    echo "Availability added successfully.";
}
else {
    echo "Error adding availability.";
}
}
?>
<form id = "availability-form" method="POST" action="add_availability.php">