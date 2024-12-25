<?php
require_once 'config/database.php';
require_once 'classes/doctor.php';
require_once 'classes/patient.php';
require_once 'classes/appointment.php';

$database = new Database();
$db = $database->connect();

$doctor = new Doctor($db);
$appointment = new Appointment($db);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['cancel_appointment'])) {
        //Handle appointment cancellation
        $appointment_id = $_POST['appointment_id'];
        if ($appointment->cancel_appointment()) {
            echo "Appointment cancelled successfully!";

        } else {
            echo "Failed to cancel appointment";
        }
    } elseif (isset($_POST['mark_checked_up'])) {
        //Handle making appointment as checked up
        $appointment->id = $_POST['appointment_id'];
        if ($appointment->markCheckedUp()) {
            echo "Appointment marked as checked up!";

        } else {
            echo "Failed to check appointment";
        }
    }
}


//Get all the appointments for a doctor (for simplicity, assuming doctor's ID is 1)
$doctor_id = 1;    //this should be dynamic based on the logged in doctor
$appointments = $appointment->getappointmentById($doctor_id);

echo "<h2>Appointments for Dr. Smith</h2>";
echo "<table>";
echo "<tr><th>Patient</th><th>Date</th><th>Time</th><th>Status</th><th>Actions</th></tr>";
while ($row = $appointments->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row['patient_id'] . "</td>";
    echo "<td>" . $row['appointment_date'] . "</td>";
    echo "<td>" . $row['appointment_time'] . "</td>";
    echo "<td>" . $row['status'] . "</td>";
    echo "<td>";
    if ($row['status'] == 'pending') {
        echo "<form action='' method='POST' style='display:inline;'>
        <input type='hidden' name='appointment_id' value='" . $row['id'] . "'>
         <input type='submit' name='cancel_appointment' value='cancel'>
       </form> ";
    }                                                     
    if ($row['status'] == 'confirmed') {
        echo "<form action='' method='POST' style='display:inline;'>
        <input type='hidden' name='appointment_id' value='" . $row['id'] . "'>
         <input type='submit' name='mark_checked_up' value='Mark as checked Up'>
       </form> ";
    }
    echo "</td>";
    echo "</tr>";
}

