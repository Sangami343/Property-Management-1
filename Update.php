<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Property</title>
<style>
body {
font-family: Arial, sans-serif;
background-color: #f4f4f4;
margin: 0;
padding: 0;
}

h1 {
color: #4CAF50;
text-align: center;
margin-top: 20px;
}

form {
background-color: #fff;
max-width: 600px;
margin: 20px auto;
padding: 20px;
border-radius: 8px;
box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

label {
display: block;
margin-bottom: 8px;
font-weight: bold;
}

input[type="text"],
input[type="number"],
input[type="file"],
textarea,
select {
width: 100%;
padding: 10px;
margin-bottom: 20px;
border: 1px solid #ccc;
border-radius: 4px;
box-sizing: border-box;
}

input[type="checkbox"] {
margin-right: 10px;
}

button {
background-color: #4CAF50;
color: white;
padding: 10px 20px;
border: none;
border-radius: 4px;
cursor: pointer;
font-size: 16px;
}

button:hover {
background-color: #45a049;
}

.center {
text-align: center;
}
</style>
</head>
<body>
<center>
<h1>UPDATE PROPERTY</h1>

<!-- property Dropdown -->
<?php
$con = new mysqli("localhost", "root", "", "project");
$sql = "SELECT * FROM property";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_all($result, MYSQLI_NUM);
$len = count($row);
echo "<select name='Plist' id='Plist' onchange='property()'>";
echo "<option value=''>Select Property</option>";
for ($i = 0; $i < $len; $i++) {
echo "<option value='" . $row[$i][0] . "'>" . $row[$i][1] . "</option>";
}
echo "</select>";
?>
<br><br>

<!-- Form Fields -->
<form id="propertyform">
<input type="text" id="propertyid" name="propertyid" style="display: none;"><br>
<label>Property Type</label>
<input type="text" id="propertytype" placeholder="propertytype" required style="display: none;"><br><br>
<label>No. Of Units</label>
<input type="text" id="numberofunits" placeholder="numberofunits" required style="display: none;"><br><br>
<label>Property Address</label>
<input type="text" id="propertyaddress" placeholder="propertyaddress" required style="display: none;"><br><br>
<label>City</label>
<input type="text" id="city" placeholder="city" required style="display: none;"><br><br>
<label>State</label>
<input type="text" id="state" placeholder="state" required style="display: none;"><br><br>
<label>Country</label>
<input type="text" id="country" placeholder="country" required style="display: none;"><br><br>
<label>Postal Code</label>
<input type="text" id="postalcode" placeholder="postalcode" required style="display: none;"><br><br>
<label>Property Features</label><br>
<label><input type="checkbox" id="clubhouse" name="propertyfeatures" value="ClubHouse" style="display: none;"> ClubHouse</label><br>
<label><input type="checkbox" id="elevator" name="propertyfeatures" value="Elevator" style="display: none;"> Elevator</label><br>
<label><input type="checkbox" id="parking" name="propertyfeatures" value="Parking" style="display: none;"> Parking</label><br>
<label><input type="checkbox" id="wheelchairaccess" name="propertyfeatures" value="Wheelchair Access" style="display: none;"> Wheelchair Access</label><br><br>
<label>Description</label>
<textarea id="description" placeholder="description" required style="display: none;"></textarea><br><br>
<label>Image</label>
<input type="file" id="image" name="image" style="display: none;"><br><br>

<!-- Unit Dropdown -->
<div id="unit">
<select name='Ulist' id='Ulist' onchange='Unit()'>
<option value=''>Select Unit</option>
</select>
</div>
<br><br>

<input type="text" id="unitid" name="unitid" style="display: none;"><br>
<label>Unit Type</label>
<input type="text" id="unittype" placeholder="unittype" required style="display: none;"><br><br>
<label>Area</label>
<input type="text" id="area" placeholder="area" required style="display: none;"><br><br>
<label>Number Of Rooms</label>
<input type="text" id="room" placeholder="room" required style="display: none;"><br><br>
<label>Feet</label>
<input type="text" id="feet" placeholder="feet" required style="display: none;"><br><br>
<label>Base Rent</label>
<input type="text" id="rent" placeholder="rent" required style="display: none;"><br><br>
<label>Advance</label>
<input type="text" id="advance" placeholder="advance" required style="display: none;"><br><br>
<label>Frequency</label>
<input type="text" id="frequency" placeholder="frequency" required style="display: none;"><br><br>
<label>Unit Features</label><br>
<label><input type="checkbox" id="building" name="unitfeatures" value="Building" style="display: none;"> Building</label><br>
<label><input type="checkbox" id="water" name="unitfeatures" value="Water" style="display: none;"> Water</label><br>
<label><input type="checkbox" id="plotsofland" name="unitfeatures" value="Plots Of Land" style="display: none;"> Plots Of Land</label><br>
<label><input type="checkbox" id="commercialindustries" name="unitfeatures" value="Commercial Industries" style="display: none;"> Commercial Industries</label><br>
<label><input type="checkbox" id="dishwasher" name="unitfeatures" value="DishWasher" style="display: none;"> DishWasher</label><br><br>
<label>Unit Description</label>
<textarea id="unitdescription" placeholder="unitdescription" required style="display: none;"></textarea><br><br>
<label>Unit Image</label>
<input type="file" id="unitimage" name="unitimage" style="display: none;"><br><br>
<button type="button" id="Submit" onclick="update()">UPDATE</button>
<button type="submit" onclick="window.location.href='dashborad.php'">BACK</button>
</form>
</center>

<!-- JavaScript to handle model loading and form fields -->
<script>
function property() {
var propertyid = document.getElementById('Plist').value;
document.getElementById('propertytype').style.display = "block";
document.getElementById('numberofunits').style.display = "block";
document.getElementById('propertyaddress').style.display = "block";
document.getElementById('city').style.display = "block";
document.getElementById('state').style.display = "block";
document.getElementById('country').style.display = "block";
document.getElementById('postalcode').style.display = "block";
var checkboxes = document.getElementsByName('propertyfeatures');
for (var i = 0; i < checkboxes.length; i++) {
checkboxes[i].style.display = "block";
}
document.getElementById('description').style.display = "block";
document.getElementById('image').style.display = "block";

const xhttp = new XMLHttpRequest();
xhttp.onload = function() {
var Pdata = this.responseText.split("@");
var propertyDetails = Pdata[0].split("&");
document.getElementById('propertyid').value = propertyDetails[0];
document.getElementById('propertytype').value = propertyDetails[1];
document.getElementById('numberofunits').value = propertyDetails[2];
document.getElementById('propertyaddress').value = propertyDetails[3];


document.getElementById('city').value = propertyDetails[4];
document.getElementById('state').value = propertyDetails[5];
document.getElementById('country').value = propertyDetails[6];
document.getElementById('postalcode').value = propertyDetails[7];
var features = propertyDetails[8].split(", ");
for (var i = 0; i < features.length; i++) {
document.getElementById(features[i].toLowerCase()).checked = true;
}
document.getElementById('description').value = propertyDetails[9];

var UnitOptions = "<option value=''>Select Unit</option>";
var Units = Pdata[1].split("%");
for (var i = 0; i < Units.length - 1; i++) {
var Unit = Units[i].split("*");
UnitOptions += "<option value='" + Unit[0] + "'>" + Unit[1] + "</option>";
}
document.getElementById('Ulist').innerHTML = UnitOptions;
}
xhttp.open("GET", "Update1.php?Id=" + propertyid);
xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xhttp.send();
}

function Unit() {
var unitid = document.getElementById('Ulist').value;
document.getElementById('unittype').style.display ="block";
document.getElementById('area').style.display = "block";
document.getElementById('room').style.display = "block";
document.getElementById('feet').style.display = "block";
document.getElementById('rent').style.display = "block";
document.getElementById('advance').style.display = "block";
document.getElementById('frequency').style.display = "block";
var checkboxes = document.getElementsByName('unitfeatures');
for (var i = 0; i < checkboxes.length; i++) {
checkboxes[i].style.display = "block";
}
document.getElementById('unitdescription').style.display = "block";
document.getElementById('unitimage').style.display = "block";

const xhttp = new XMLHttpRequest();
xhttp.onload = function() {
var unitDetails = this.responseText.split("*");
document.getElementById('unitid').value = unitDetails[0];
document.getElementById('unittype').value = unitDetails[1];
document.getElementById('area').value = unitDetails[2];
document.getElementById('room').value = unitDetails[3];
document.getElementById('feet').value = unitDetails[4];
document.getElementById('rent').value = unitDetails[5];
document.getElementById('advance').value = unitDetails[6];
document.getElementById('frequency').value = unitDetails[7];
var features = unitDetails[8].split(", ");
for (var i = 0; i <features.length; i++) {
document.getElementById(features[i].toLowerCase()).checked = true;
}
document.getElementById('unitdescription').value = unitDetails[9];
}
xhttp.open("GET", "Update1.php?Unit_Id=" + unitid);
xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xhttp.send();
}

function update() {
var formData = new FormData();
formData.append("propertyid", document.getElementById("propertyid").value);
formData.append("propertytype", document.getElementById("propertytype").value);
formData.append("numberofunits", document.getElementById("numberofunits").value);
formData.append("propertyaddress", document.getElementById("propertyaddress").value);
formData.append("city", document.getElementById("city").value);
formData.append("state", document.getElementById("state").value);
formData.append("country", document.getElementById("country").value);
formData.append("postalcode", document.getElementById("postalcode").value);
var propertyfeatures = [];
var checkboxes = document.getElementsByName("propertyfeatures");
for (var i = 0; i < checkboxes.length; i++) {
if (checkboxes[i].checked) {
propertyfeatures.push(checkboxes[i].value);
}
}
formData.append("propertyfeatures", propertyfeatures.join(", "));
formData.append("description", document.getElementById("description").value);
formData.append("Propertyimage", document.getElementById("image").files[0]);

formData.append("unitid", document.getElementById("unitid").value);
formData.append("unittype", document.getElementById("unittype").value);
formData.append("area", document.getElementById("area").value);
formData.append("room", document.getElementById("room").value);
formData.append("feet", document.getElementById("feet").value);
formData.append("baserent", document.getElementById("rent").value);
formData.append("advance", document.getElementById("advance").value);
formData.append("frequency", document.getElementById("frequency").value);
var unitfeatures = [];
var checkboxes = document.getElementsByName("unitfeatures");
for (var i = 0; i < checkboxes.length; i++) {
if (checkboxes[i].checked) {
unitfeatures.push(checkboxes[i].value);
}
}
formData.append("unitfeatures", unitfeatures.join(", "));
formData.append("unitdescription", document.getElementById("unitdescription").value);
formData.append("unitimage", document.getElementById("unitimage").files[0]);

var xhr = new XMLHttpRequest();
xhr.open("POST", "PUpdate.php", true);

xhr.onreadystatechange = function() {
if (xhr.readyState == 4 && xhr.status == 200) {
alert(xhr.responseText);
location.reload();
}
}

xhr.send(formData);
}
</script>
</body>
</html>