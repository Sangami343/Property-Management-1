<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Delete Page</title>
<style>
body {
font-family: Arial, sans-serif;
background-color: #f4f4f4;
margin: 0;
padding: 0;
}
h1, h2 {
text-align: center;
color: #333;
}
table {
font-family: Arial, sans-serif;
border-collapse: collapse;
width: 80%;
margin: 20px auto;
background-color: #fff;
box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
td, th {
border: 1px solid #dddddd;
text-align: left;
padding: 12px;
}
tr:nth-child(even) {
background-color: #f9f9f9;
}
tr:hover {
background-color: #f1f1f1;
}
th {
background-color: #007BFF; /* Blue */
color: white;
}
button {
background-color: #007BFF; /* Blue */
border: none;
color: white;
padding: 10px 20px;
text-align: center;
text-decoration: none;
display: inline-block;
font-size: 16px;
margin: 10px 2px;
cursor: pointer;
border-radius: 5px;
}
button:hover {
background-color: #0056b3;
}
select {
padding: 10px;
margin: 20px auto;
display: block;
width: 200px;
font-size: 16px;
}
.center {
text-align: center;
}
</style>
</head>
<body>
<h1>DELETE PAGE!</h1><br>
<div class="center">
<?php
session_start();
$con = new mysqli("localhost", "root", "", "project");
if ($con->connect_error) {
die("Connection failed: " . $con->connect_error);
}

$sql = "SELECT * FROM property WHERE status = '0'";
$result = mysqli_query($con, $sql);
if (!$result) {
die("Query failed: " . mysqli_error($con));
}

$row = mysqli_fetch_all($result, MYSQLI_NUM);
$len = count($row);

echo "<select name='Ulist' id='Ulist' onchange='check()'>";
echo "<option value=''>Select Property</option>"; // Default option
for ($i = 0; $i < $len; $i++) {
echo "<option value='" . $row[$i][0] . "'>" . ($row[$i][1]) . "</option>";
}
echo "</select>";

mysqli_close($con);
?>
</div>
<h2>Selected Units</h2>
<table id="unit_table">
<tr>
<th>ID</th>
<th>Unit Name</th>
<th>Unit Type</th>
<th>Area</th>
<th>Room</th>
<th>Feet</th>
<th>Rent</th>
<th>Frequency</th>
<th>Unit Features</th>
<th>Unit Description</th>
<th>Property Id</th>
<th>Image</th>
<th>Action</th>
</tr>
</table>
<br>
<button type="button" onclick="window.location.href='dashborad.php'">BACK</button>

<script>
function check() {
var value = document.getElementById('Ulist').value;

if (value === '') {
// Clear the table if no property is selected
var table = document.getElementById('unit_table');
table.innerHTML = `<tr>
<th>ID</th>
<th>Unit Name</th>
<th>Unit Type</th>
<th>Area</th>
<th>Room</th>
<th>Feet</th>
<th>Rent</th>
<th>Frequency</th>
<th>Unit Features</th>
<th>Unit Description</th>
<th>Property Id</th>
<th>Image</th>
<th>Action</th>
</tr>`;
return;
}

const xhttp = new XMLHttpRequest();
xhttp.onload = function() {
var response = this.responseText;
var Udata = response.split('*');

var table = document.getElementById('unit_table');
table.innerHTML = `<tr>
<th>ID</th>
<th>Unit Name</th>
<th>Unit Type</th>
<th>Area</th>
<th>Room</th>
<th>Feet</th>
<th>Rent</th>
<th>Frequency</th>
<th>Unit Features</th>
<th>Unit Description</th>
<th>Property Id</th>
<th>Image</th>
<th>Action</th>
</tr>`;

for (var i = 0; i < Udata.length; i++) {
var data = Udata[i].split('`^`');
var row = table.insertRow();
var cell1 = row.insertCell(0);
var cell2 = row.insertCell(1);
var cell3 = row.insertCell(2);
var cell4 = row.insertCell(3);
var cell5 = row.insertCell(4);
var cell6 = row.insertCell(5);
var cell7 = row.insertCell(6);
var cell8 = row.insertCell(7);
var cell9 = row.insertCell(8);
var cell10 = row.insertCell(9);
var cell11 = row.insertCell(10);
var cell12 = row.insertCell(11);
var cell13 = row.insertCell(12);

cell1.innerHTML = data[0];
cell2.innerHTML = data[1];
cell3.innerHTML = data[2];
cell4.innerHTML = data[3];
cell5.innerHTML = data[4];
cell6.innerHTML = data[5];
cell7.innerHTML = data[6];
cell8.innerHTML = data[7];
cell9.innerHTML = data[8];
cell10.innerHTML = data[9];
cell11.innerHTML = data[10];
cell12.innerHTML = `<img src="image/uploads/${data[11]}" alt="Image" style="width:150px;height:auto;"><br>`;
cell13.innerHTML = `<button onclick="deleteRow('${data.join(',')}')">Delete</button>`;
}
}

xhttp.open('GET', 'Updelete.php?Property_Name=' + value, true);
xhttp.send();
}

function deleteRow(data) {
var values = data.split(',');
var id = values[0];
var xhr = new XMLHttpRequest();
xhr.open("POST", "delete1.php", true);
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr.onreadystatechange = function() {
if (xhr.readyState == 4 && xhr.status == 200) {
alert("DELETE SUCCESSFULLY");
check(); // Refresh the table data
}
};
xhr.send("id=" + id);
}
</script>
</body>
</html>