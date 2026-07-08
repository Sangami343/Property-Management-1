<?php
$con = new mysqli("localhost", "root", "", "project");
// echo "sangami";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$property_id = $_POST["property_id"];
$unit_id = $_POST["unit_id"];
$rent = $_POST["rent"];
$date = $_POST["date"];
$edate = $_POST["edate"];
$securitydeposit = $_POST["deposit"];
$Status = 1;

$sql1 = "SELECT * FROM registerform WHERE id = '" . $_SESSION['id'] . "'";
$result1 = mysqli_query($con, $sql1);
$row1 = mysqli_fetch_assoc($result1);

$sql = "INSERT INTO lease (User_Id,Property_Id, Unit_Id, Rent, Start_Date, End_Date, Security_Deposit, Submit_Date, Status)
VALUES ('$property_id', '$unit_id', '$rent', '$date', '$edate', '$securitydeposit', NOW(), '$Status')";

echo $sql;
$result = mysqli_query($con, $sql);
echo $result;
}
?>