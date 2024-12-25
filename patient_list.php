<?php 
include_once 'config/database.php'; 
include_once 'classes/patient.php'; 

$database = new Database(); 
$db = $database->connect(); 

$patient = new Patient($db); 
$result = $patient->read();
?>

<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title> Patient List</title> 
</head> 
<body> 
    <h2> Patient List</h2> 
    <table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Gender</th>
        <th>Date of Birth</th>
        <th>Actions</th>
    </tr>
    <?php
    while ($row = $result->fetch(PDO::FETCH_ASSOC)){
        echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['name']}</td>
        <td>{$row['email']}</td>
        <td>{$row['phone']}</td>
        <td>{$row['gender']}</td>
        <td>{$row['dob']}</td>
        <td>
        <a href='edit_patient.php>?id={$row['id']}'>Edit</a>
           <a href='delete_patient.php>?id={$row['id']}'
           onclick = 'return confirm(\"Are You Sure  You
            Want To Delete This Patient?\")'>Delete</a>
        </td>
        </tr>";

    }
    ?>
    </table>