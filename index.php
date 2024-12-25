<?php
session_start();
require_once 'config/Database.php'; // Ensure this path is correct.

$database = new Database();
$db = $database->connect();

if (!$db) {
    die("Database connection failed");
}

// Handle registration form submission
if (isset($_POST['register'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = isset($POST['role']) ? $_POST['role'] : 'patient';

    try {
        // Check if the username already exists
        $checkStmt = $db->prepare("SELECT * FROM user WHERE username = ?");
        $checkStmt->execute([$username]);
        if ($checkStmt->fetch()) {
            echo "Username already exists. Please choose a different username.";
        } else {
            // Insert new user into the database
            $stmt = $db->prepare("INSERT INTO user (username, password, role) VALUES (?, ?, ?)");
            $role = 'user'; // Default role for new users
            $stmt->execute([$username, $password, $role]);
            echo "Registration successful! You can now log in.";
        }
    } catch (PDOException $e) {
        echo "Error during registration: " . $e->getMessage();
    }
    exit;
}

// Handle login form submission
if (isset($_POST['login'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    try {
        // Retrieve user from the database
        $stmt = $db->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Password is valid; log the user in
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Invalid username or password!";
        }
    } catch (PDOException $e) {
        echo "Error during login: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Appointment System - Login/Register</title>
</head>
<body>

    <h1>Doctor Appointment System - Login/Register</h1>
    
    <h2>Register</h2>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit" name="register">Register</button>
    </form>
    
    <h2>Login</h2>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit" name="login">Login</button>
    </form>
</body>
</html>
