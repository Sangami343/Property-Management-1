<?php
session_start();
$con = new mysqli("localhost", "root", "", "project");
if ($con->connect_error) die("Connection failed: " . $con->connect_error);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $startdate = $_POST['date'];
    $enddate = $_POST['edate'];
    $rent = $_POST['rent'];
    $deposit = $_POST['deposit'];
    $maintenance = $_POST['Maintenance'];
    $propertyID = $_POST['propertyID'];
    $unitID = $_POST['unitID'];
    $userID = $_POST['userID'];
    $leaseID = $_POST['leaseID']; // ✅ Correct name match

    $status = 0;

    if (empty($name) || empty($startdate) || empty($enddate) || empty($deposit) || empty($maintenance)) {
        echo "All fields are required.";
        exit;
    }

    $sql = "INSERT INTO agreement 
            (User_Id, Property_id, Unit_Id, Lease_id, Name, Start_Date, End_Date, Rent, Security_Deposit, Maintenance, Status, Submit_Date)
            VALUES ('$userID', '$propertyID', '$unitID', '$leaseID', '$name', '$startdate', '$enddate', '$rent', '$deposit', '$maintenance', '$status', NOW())";

    if (mysqli_query($con, $sql)) {
        echo "success";
    } else {
        echo "Error saving agreement: " . mysqli_error($con);
    }
}
?>
