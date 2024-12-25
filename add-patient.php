<?php 
include_once 'config/database.php'; 
include_once 'classes/patient.php'; 

$database = new Database(); 
$db = $database->connect(); 
$patient = new Patient($db); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
$patient->name = $_POST['name']; 
$patient->specialization = $_POST['specialization']; 
$patient->email = $_POST['email']; 
$patient->phone = $_POST['phone'];

if ($patient->create()) { 
echo "Patient added successfully!"; 
} else { 
echo "Error adding patient."; 
} 
} 
?> 

<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Add Patient</title> 
</head> 
<body> 
    <h2>Add New Patient</h2> 
    <form action="add-patient.php" method="POST"> 
        <label>Name:</label><br> 
        <input type="text" id="name" name="name" required placeholder="Enter Patient Name "><br> 
        <label>Email:</label><br> 
        <input type="email" id="email" name="email"><br> 
        <label>Phone:</label><br> 
        <input type="text" id="phone"  name="phone"><br> 
        <input type="submit" value="Add Patient"> 
</form> 

<?php

$patients = $patient->read();

echo "<h2>Patient List</h2>";
echo "<table border='1'>
<tr>
   <th>Name</th>
   <th>Email</th>
   <th>Phone</th>
</tr>";


while ($row = $patients->fetch(PDO::FETCH_ASSOC)) { 
  echo "<tr>
     <td>{$row['name']}</td>
     <td>{$row['email']}</td>
      <td>{$row['phone']}</td>
  </tr>";
}
echo "</table>";
?>
</body> 
</html> 