<?php
$con = new mysqli("localhost", "root", "", "project");
$Property_id = $_GET["Id"];
$sql = "SELECT * FROM property WHERE Id = ".$Property_id;
//echo $sql;
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_all($result, MYSQLI_NUM);
//print_r($row);
$Property_id=$row[0][0];
$Property_Type =$row[0][2];
$Number_Of_Units =$row[0][3];
$Property_Address =$row[0][4];
$City =$row[0][5];
$State =$row[0][6];
$Country =$row[0][7];
$Postal_Code =$row[0][8];
$Property_Features =$row[0][9];
$Description=$row[0][10];
$Image =$row[0][11];
$propertyDetails = $Property_id. "&".$Property_Type."&".$Number_Of_Units."&".$Property_Address."&".$City. "&".$State. "&".$Country. "&".$Postal_Code."&".$Property_Features."&".$Description."&".$Image;
$sql = "SELECT * FROM unit WHERE Property_Id = ".$Property_id;
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_all($result, MYSQLI_NUM);
//print_r($row);
$len = count($row);
$str="";
$str .= $propertyDetails."@";
for ($i = 0; $i < $len; $i++) {
foreach ($row[$i] as $res) {
$str .= $res . "*";
}
$str .= "%";

}
echo $str;
// Unit Connection

$Unitid = $_GET["Unit_Id"];
$sql = "SELECT * FROM unit WHERE Id = ".$Unitid;
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_all($result, MYSQLI_NUM);

$id=$row[0][0];
//$unitname =$row[0][2];
$unittype =$row[0][2];
$area = $row[0][3];
$room = $row[0][4];
$feet = $row[0][5];
$rent = $row[0][6];
$advance = $row[0][7];
$frequency= $row[0][8];
$unitfeatures=$row[0][9];
$unitdescription= $row[0][10];
$Image =$row[0][11];
echo $id."*".$unittype."*".$area."*".$room."*".$feet."*".$rent."*".$advance."*".$frequency."*".$unitfeatures."*".$unitdescription."*".$Image;
?>