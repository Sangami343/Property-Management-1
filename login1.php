<?php
session_start();

$con = new mysqli("localhost", "root", "", "project");

if ($con->connect_error) {
die("Connection failed: " . $con->connect_error);
}

// Get username and password from POST request
$username = $_POST['username'];
$password = $_POST['password'];

$username = mysqli_real_escape_string($con, $username);
$password = mysqli_real_escape_string($con, $password);



// Prepare and execute query
$sql = "SELECT id FROM registerform WHERE User_Name = '$username' AND Password = '$password'";
$result = mysqli_query($con, $sql);

if ($result->num_rows > 0) {
$row = $result->fetch_assoc();
$_SESSION['id'] = $row['id'];
echo "success";
} else {
echo "Invalid username or password";
}

$con->close();
?>