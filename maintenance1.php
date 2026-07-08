<?php
$con = new mysqli("localhost", "root", "", "project");
if ($con->connect_error) {
die("Connection failed: " . $con->connect_error);
}


$maintenanceType = $_POST['maintenanceType'];
$priority = $_POST['priority'];
$comments = $_POST['comments'];
$image = $_FILES['image']['name'];
$Status = 2;
$target_dir = "uploads/";
$target_file = $target_dir . basename($image);

// Check if the IDs exist in their respective tables
$userCheck = $con->query("SELECT id FROM register WHERE id = '$userId'");
$unitCheck = $con->query("SELECT id FROM unit WHERE id = '$unitId'");
$propertyCheck = $con->query("SELECT id FROM property WHERE id = '$propertyId'");
$leaseCheck = $con->query("SELECT id FROM lease WHERE id = '$leaseId'");

if ($userCheck->num_rows > 0 && $unitCheck->num_rows > 0 && $propertyCheck->num_rows > 0 && $leaseCheck->num_rows > 0) {
// Move the uploaded file to the target directory
if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
$sql = "INSERT INTO maintenance (User_Id, Property_Id, Unit_Id, Lease_Id, Maintenance_Type, Priority, Comment, Image,Status) VALUES ('$userId',, '$propertyId' '$unitId', '$leaseId', '$maintenanceType', '$priority', '$comments', '$image','$Status')";

if (mysqli_query($con, $sql)) {
echo "Maintenance request submitted successfully!";
} else {
echo "Error: " . $sql . "<br>" . mysqli_error($con);
}
} else {
echo "Sorry, there was an error uploading your file.";
}
} else {
echo "Invalid user, unit, property, or lease ID.";
}

mysqli_close($con);
?>