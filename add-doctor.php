<?php 
include_once 'config/database.php'; 
include_once 'classes/doctor.php'; 

$database = new Database(); 
$db = $database->connect(); 
$doctor = new Doctor($db); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
$doctor->name = $_POST['name']; 
$doctor->specialization = $_POST['specialization']; 
$doctor->email = $_POST['email']; 
$doctor->phone = $_POST['phone']; 

if ($doctor->create()) { 
echo "Doctor added successfully!"; 
} else { 
echo "Error adding doctor."; 
} 
} 
?> 
<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Add Doctor</title> 
</head> 
<body> 
    <h2>Add New Doctor</h2> 
    <form action="add-doctor.php" method="POST"> 
        <label>Name:</label><br> 
        <input type="text" name="name"><br> 
        <label>Specialization:</label><br> 
        <input type="text" name="specialization"><br> 
        <label>Email:</label><br> 
        <input type="email" name="email"><br> 
        <label>Phone:</label><br> 
        <input type="text" name="phone"><br> 
        <input type="submit" value="Add Doctor"> 
</form>

<?php

$doctors = $doctor->read();

echo "<h2>Doctor List</h2>";
echo "<table border='1'>
<tr>
   <th>Name</th>
   <th>Email</th>
   <th>Specialization</th>
   <th>Phone</th>
</tr>";


while ($row = $doctors->fetch(PDO::FETCH_ASSOC)) { 
  echo "<tr>
     <td>{$row['name']}</td>
     <td>{$row['email']}</td>
     <td>{$row['specialization']}</td>
    <td>{$row['phone']}</td>
  </tr>";
}
echo "</table>";
?>
</body> 
</html> 