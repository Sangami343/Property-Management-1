<?php
session_start();

// Assuming you have the user's unique identifier stored in the session
$user_id = $_SESSION['id'];

$con = new mysqli("localhost", "root", "", "project");

if ($con->connect_error) {
die("Connection failed: " . $con->connect_error);
}

echo "sangami";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$unitname = $_POST["unitname"];
$location = $_POST["location"];
$squarefeet = $_POST["feet"];
$scale = $_POST["scale"];
$Status = 5;

// Insert into oldhistorytenant
$sql = "INSERT INTO oldhistorytenant (Unit_Name, Location, Square_Feet, Scale, Status)
VALUES ('$unitname', '$location', '$squarefeet', '$scale', '$Status')";
echo $sql;
$result = mysqli_query($con, $sql);
echo $result;

// Update status in registerform for the logged-in user
if ($result) {
$update_sql = "UPDATE registerform SET status = 2 WHERE id = '$user_id'";
$update_result = mysqli_query($con, $update_sql);
if ($update_result) {
echo "Status updated successfully.";
} else {
echo "Error updating status: " . mysqli_error($con);
}
} else {
echo "Error inserting data: " . mysqli_error($con);
}
}

$con->close();
?>
