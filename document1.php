<?php
$con = new mysqli("localhost", "root", "", "project");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$name1 = $_POST["name"];
echo $name1;
$gender = $_POST["gender"];
echo $gender;
$identity_proof = $_FILES["proof"]["name"];
echo $identity_proof;
$address_proof = $_FILES["address"]["name"];
echo $address_proof;
$pan_number = $_POST["number"];
echo $pan_number;
$document_certificate = $_FILES["certificate"]["name"];
echo $document_certificate;
$fire = $_FILES["fire"]["name"];
echo $fire;
$trade = $_FILES["trade"]["name"];
echo $trade;
$status = 2;
echo $status;
$propertyid = $_POST["propertyID"];
echo $propertyid;
$unitid = $_POST["unitID"];
echo $unitid;


// Move uploaded files to a designated directory
move_uploaded_file($_FILES['proof']['tmp_name'], "image/uploads/" . $identity_proof);
move_uploaded_file($_FILES['address']['tmp_name'], "image/uploads/" . $address_proof);
move_uploaded_file($_FILES['certificate']['tmp_name'], "image/uploads/" . $document_certificate);
move_uploaded_file($_FILES['fire']['tmp_name'], "image/uploads/" . $fire);
move_uploaded_file($_FILES['trade']['tmp_name'], "image/uploads/" . $trade);

// Fetch User_id from registerform table
$sql1 = "SELECT * FROM registerform WHERE id = '" . $_SESSION['id'] . "'";
$result1 = mysqli_query($con, $sql1);
$row1 = mysqli_fetch_assoc($result1);

// Insert data into the document table
$sql = "INSERT INTO document (Name, Gender, Identity_Proof, Address_Proof, Pan_Number, Document_Certificate, Fire_Noc, Trade_Licence, User_id,Property_Id,Unit_Id, Status) VALUES ('$name1', '$gender', '$identity_proof', '$address_proof', '$pan_number', '$document_certificate', '$fire', '$trade', '" . $_SESSION['id'] . "','$propertyid','$unitid', '$status')";

if (mysqli_query($con, $sql)) {
echo "Record inserted successfully";
} else {
echo "Error: " . mysqli_error($con);
}
}
$con->close();
?>
