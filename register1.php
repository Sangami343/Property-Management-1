<?php
$con=new mysqli("localhost","root","","project");
echo "sangami";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//$row = mysqli_fetch_all($result, MYSQLI_NUM);
$username =$_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];
$confirmpassword= $_POST["confirmpassword"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$phone = $_POST["phone"];
$address = $_POST["address"];
$Status=1;
$sql = "INSERT INTO registerform (User_Name, Email, Password,Confirm_Password,First_Name,Last_Name,Phone,Address,Status)
 VALUES ('$username', '$email', '$password','$confirmpassword','$firstname','$lastname','$phone ','$address','$Status')";
echo $sql;
$result=mysqli_query($con, $sql);
echo $result;
 }
?>