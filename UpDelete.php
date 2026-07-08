<?php
$con = new mysqli("localhost", "root", "", "project");

if(isset($_GET['Property_Name'])) {
    

$Brand_id = $_GET['Property_Name'];
$sql = "SELECT * FROM unit WHERE Property_Id='$Brand_id' AND Status=0";
$result = mysqli_query($con, $sql);
//echo  mysqli_fetch_assoc($result);
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
$data[] = implode('`^`', $row);
}

echo implode('*', $data);
}
?>