<!-- <?php
include_once 'config/database.php';
include_once 'classes/patient.php';
$database = new Database();
$db = $database->connect();
$appointment = new $appointment($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointment->name = $_POST['doctor_id'];
    $appointment->email = $_POST['patient_id'];
    $appointment->phone = $_POST['appointment_date'];
    $appointment->gender = $_POST['appointment_time'];
    $appointment->dob = $_POST['Schedule'];


    if ($appointment->create()) {
        echo "Appointment successfully!";

    } else {
        echo "Error Booking appointment";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>book Appointment</title>
</head>

<body>
    <h2>Book Appointment<h2>
            <form action="book_appointment.php" method="POST">
                <label>Doctor:</label><br>
                <select name="doctor_id">
                    <?php include_once 'classes/Doctor.php';
                    $doctor = new Doctor($sd);
                    $result = $doctor->read();
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['id']}'>{$row['name']} {$row['specialization']}
                )</option>";
                    } ?>
                </select><br>
                <label>Patient:</label><br>
                <select name="patient_id">
                    <?php include_once 'classes/Patient.php';
                    $patient = new Patient($sd);
                    $result = $patient->read();
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['id']}'>{$row['name']} 
                )</option>";
                    } ?>
                </select><br>
                <label>Date:</label><br>
                <input> type ="date" name ="appointment_date"><br>
                <label>time:</label><br>
                <input> type ="time" name ="appointment_time"><br>
                <input> type ="submit" name ="Book Appointment"><br>
            </form>
</body>
<script>
$(document).ready(function(){
  $('#appointment-form').on('submit' , function(event){<script>
$(document).ready(function(){
  $('#appointment-form').on('submit' , function(event){
    event.preventDefault(); 
    var doctor_id = $('select[name= "doctor_id"]').val();
    var patient_id = $('select[name= "doctor_id"]').val();
    var appointment_date= $('input[name= "appointment_date"]').val();
    var appointment_time= $('input[name= "appointment_time"]').val();

    if(!doctor_id || !patient_id || !appointment_date || !appointment_time){
    $('#response').html('All fields ae required.');
    return ; // prevent form submission if validation fails
    }
    var formData = $(this).serialize(); // serialize form data

    $.ajax({
        url: 'book_appoinment.php', // PHP file to handle the request
        type:'post',
        data:formData ,
        success: function(response){
            $('#response').html(response); // Display success or error message
        },
         error:function(){
            $('#response').html('Error processing the request.'); // Display error message
         }
    });
  });
});
</script>
    event.preventDefault(); 
    var doctor_id = $('select[name= "doctor_id"]').val();
    var patient_id = $('select[name= "doctor_id"]').val();
    var appointment_date= $('input[name= "appointment_date"]').val();
    var appointment_time= $('input[name= "appointment_time"]').val();

    if(!doctor_id || !patient_id || !appointment_date || !appointment_time){
    $('#response').html('All fields ae required.');
    return ; // prevent form submission if validation fails
    }
    var formData = $(this).serialize(); // serialize form data

    $.ajax({
        url: 'book_appoinment.php', // PHP file to handle the request
        type:'post',
        data:formData ,
        success: function(response){
            $('#response').html(response); // Display success or error message
        },
         error:function(){
            $('#response').html('Error processing the request.'); // Display error message
         }
    });
  });
});
</script>
</html> -->


<?php
include_once 'config/database.php';
include_once 'classes/Appointment.php';
include_once 'classes/Doctor.php';
include_once 'classes/Patient.php';

$database = new Database();
$db = $database->connect();

$appointment = new Appointment($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointment->doctor_id = $_POST['doctor_id'];
    $appointment->patient_id = $_POST['patient_id'];
    $appointment->appointment_date = $_POST['appointment_date'];
    $appointment->appointment_time = $_POST['appointment_time'];
    $appointment->schedule = $_POST['schedule'];

    if ($appointment->create()) {
        echo "Appointment booked successfully!";
    } else {
        echo "Error booking appointment.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
</head>
<body>
    <h2>Book Appointment</h2>
    <form id="appointment-form" action="book_appointment.php" method="POST">
        <label>Doctor:</label><br>
        <select name="doctor_id" required>
            <?php
            $doctor = new Doctor($db);
            $result = $doctor->read();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['id']}'>{$row['name']} ({$row['specialization']})</option>";
            }
            ?>
        </select><br>

        <label>Patient:</label><br>
        <select name="patient_id" required>
            <?php
            $patient = new Patient($db);
            $result = $patient->read();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['id']}'>{$row['name']}</option>";
            }
            ?>
        </select><br>

        <label>Date:</label><br>
        <input type="date" name="appointment_date" required><br>

        <label>Time:</label><br>
        <input type="time" name="appointment_time" required><br>

        <input type="submit" value="Book Appointment"><br>
    </form>
    
    <div id="response"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#appointment-form').on('submit', function(event){
                event.preventDefault(); 

                var doctor_id = $('select[name="doctor_id"]').val();
                var patient_id = $('select[name="patient_id"]').val();
                var appointment_date = $('input[name="appointment_date"]').val();
                var appointment_time = $('input[name="appointment_time"]').val();

                if (!doctor_id || !patient_id || !appointment_date || !appointment_time) {
                    $('#response').html('All fields are required.');
                    return;
                }

                var formData = $(this).serialize();

                $.ajax({
                    url: 'book_appointment.php',
                    type: 'post',
                    data: formData,
                    success: function(response) {
                        $('#response').html(response);
                    },
                    error: function() {
                        $('#response').html('Error processing the request.');
                    }
                });
            });
        });
    </script>
</body>
</html>
