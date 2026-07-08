<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
echo "User not logged in";
exit();
}

$con = new mysqli("localhost", "root", "", "project");

if ($con->connect_error) {
die("Connection failed: " . $con->connect_error);
}

$userID = $_SESSION['id'];

// Fetch unit details based on user selection
$unitID = $_POST['unitID']; // Assuming unitID is passed as a POST parameter
$sql = "SELECT Rent, Feet FROM unit WHERE Id = $unitID";
$result = $con->query($sql);

if ($result->num_rows > 0) {
$unit = $result->fetch_assoc();
$roomRent = $unit['Rent'];
$unitFeet = $unit['Feet'];
} else {
echo "Unit not found";
exit();
}

$amount = $_POST['amount'];
$comment = $_POST['comment'];
$status = 1; // Assuming 1 means completed
$propertyid = $_POST['propertyID'];
$unitid = $_POST['unitID'];

// Prepare the payment query
$sql = "INSERT INTO payment (User_id,Property_Id,Unit_Id, Amount, Unit_Feet, Unit_Rent, Comment, Status, Submit_Date) 
VALUES ('$userID', '$propertyid','$unitid','$amount', '$unitFeet', '$roomRent', '$comment', '$status', NOW())";

if ($con->query($sql) === TRUE) {
echo "Payment successful!";
} else {
echo "Error: " . $con->error;
}

$con->close();
?>
