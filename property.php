<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Property Details</title>
<style>
body {
font-family: Arial, sans-serif;
background-color: #f4f4f9;
background-size: cover;
background-repeat: no-repeat;
margin: 0;
padding: 0;
}
h1, h2 {
text-align: center;
color: #333;
}
form {
max-width: 600px;
margin: 20px auto;
background: rgba(255, 255, 255, 0.8); /* Slightly transparent background */
padding: 20px;
border-radius: 8px;
box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
label {
display: block;
margin-bottom: 8px;
font-weight: bold;
}
input[type="text"], input[type="number"], textarea, select {
width: 100;
padding: 10px;
margin-bottom: 20px;
border: 1px solid #ccc;
border-radius: 4px;
}
input[type="file"] {
margin-bottom: 20px;
}
button {
background-color: #007BFF;
border: none;
color: white;
padding: 15px 20px;
text-align: center;
text-decoration: none;
display: inline-block;
font-size: 16px;
margin: 10px 0;
border-radius: 5px;
cursor: pointer;
transition: background-color 0.3s ease;
width: 100;
}
button:hover {
background-color: #0056b3;
}
.unitForm {
margin-top: 20px;
padding: 20px;
background: #f9f9f9;
border: 1px solid #ddd;
border-radius: 8px;
}
</style>
</head>
<body>
<h1>PROPERTY DETAILS</h1>
<form id="propertyForm" enctype="multipart/form-data">
<label>Property Name*</label>
<input type="text" id="propertyname" placeholder="propertyname" required><br><br>
<label>Property Type*</label>
<input type="text" id="propertytype" placeholder="propertytype" required><br><br>
<label>No. Of Units*</label>
<input type="number" id="numberofunits" placeholder="numberofunits" required><br><br>
<label>Property Address*</label>
<input type="text" id="propertyaddress" placeholder="propertyaddress" required><br><br>
<label>City*</label>
<input type="text" id="city" placeholder="city" required><br><br>
<label>State*</label>
<input type="text" id="state" placeholder="state" required><br><br>
<label>Country*</label>
<input type="text" id="country" placeholder="country" required><br><br>
<label>Postal Code*</label>
<input type="text" id="postalcode" placeholder="postalcode" required><br><br>
<label>Property Features*</label><br>
<label><input type="checkbox" id="clubhouse" name="propertyfeatures" value="ClubHouse"> ClubHouse</label><br>
<label><input type="checkbox" id="elevator" name="propertyfeatures" value="Elevator"> Elevator</label><br>
<label><input type="checkbox" id="parking" name="propertyfeatures" value="Parking"> Parking</label><br>
<label><input type="checkbox" id="wheelchairaccess" name="propertyfeatures" value="Wheelchair Access"> Wheelchair Access</label><br><br>
<label>Description</label>
<textarea id="description" placeholder="description" required></textarea><br><br>
<label>Image</label>
<input type="file" id="image" name="image"><br><br>
</form>
<h2>UNIT DETAILS</h2>
<div id="unitFormsContainer">
<!-- Unit forms will be added here -->
</div>
<center><button type="button" id="addUnit" onclick="addunit()">Add Unit</button>
<button type="button" id="submit" onclick="property()">Submit</button></center>
<button type="submit" onclick="window.location.href='dashborad.php'">BACK</button>

<div id="demo"></div>
<script>
var unitIndex = 0;

function addunit() {
unitIndex++;
var unitFormsContainer = document.getElementById('unitFormsContainer');
var newUnitForm = document.createElement('form');
newUnitForm.className = 'unitForm';
newUnitForm.enctype = 'multipart/form-data';
newUnitForm.innerHTML = `
<label>Unit Name/Number*</label>
<input type="text" id="unitname${unitIndex}" placeholder="unitname/number" required><br><br>
<label>Unit Type</label>
<input type="text" id="unittype${unitIndex}" placeholder="unittype" required><br><br>
<label>Area*</label>
<input type="text" id="area${unitIndex}" placeholder="area" required><br><br>
<label>Number Of Rooms</label>
<input type="number" id="room${unitIndex}" placeholder="room" required>
<label>Feet</label>
<select name="feet" id="feet${unitIndex}">
<option value="squarefeet">SquareFeet</option>
<option value="meterfeet">MeterFeet</option>
</select><br><br>
<label>Base Rent*</label>
<input type="text" id="rent${unitIndex}" placeholder="rent" required>
<label>Advance Pay*</label>
<input type="text" id="advance${unitIndex}" placeholder="advance" required>
<label>Frequency</label>
<select name="frequency" id="frequency${unitIndex}">
<option value="monthly">Monthly</option>
<option value="daily">Daily</option>
<option value="weekly">Weekly</option>
<option value="biweekly">Bi-Weekly</option>
</select><br><br>
<label>Unit Features*</label><br>
<label><input type="checkbox" id="building${unitIndex}" name="unitfeatures${unitIndex}" value="Building"> Building</label><br>
<label><input type="checkbox" id="water${unitIndex}" name="unitfeatures${unitIndex}" value="Water"> Water</label><br>
<label><input type="checkbox" id="plotsofland${unitIndex}" name="unitfeatures${unitIndex}" value="Plots Of Land"> Plots Of Land</label><br>
<label><input type="checkbox" id="commercialindustries${unitIndex}" name="unitfeatures${unitIndex}" value="Commercial Industries"> Commercial Industries</label><br>
<label><input type="checkbox" id="dishwasher${unitIndex}" name="unitfeatures${unitIndex}" value="DishWasher"> DishWasher</label><br><br>
<label>Unit Description</label>
<textarea id="unitdescription${unitIndex}" placeholder="unitdescription" required></textarea><br><br>
<label>Unit Image</label>
<input type="file" id="unitimage${unitIndex}" name="unitimage"><br><br>
`;
unitFormsContainer.appendChild(newUnitForm);
}

function property() {
    // alert(unitIndex);
var propertyname = document.getElementById("propertyname").value;
var propertytype = document.getElementById("propertytype").value;
var numberofunits = document.getElementById("numberofunits").value;
var propertyaddress = document.getElementById("propertyaddress").value;
var city = document.getElementById("city").value;
var state = document.getElementById("state").value;
var country = document.getElementById("country").value;
var postalcode = document.getElementById("postalcode").value;
var checkboxes = document.querySelectorAll('input[name="propertyfeatures"]:checked');

var propertyfeatures = "";
for (var i = 0; i < checkboxes.length; i++) {
propertyfeatures += checkboxes[i].value;
if (i < checkboxes.length - 1) {
propertyfeatures += ", ";
}
}
var description = document.getElementById("description").value;
var propertyimage = document.getElementById("image").files[0];
//unit function
var addproperty = 'addproperty';
var formData = new FormData();
formData.append("property", addproperty);
formData.append("propertyname", propertyname);
formData.append("propertytype", propertytype);
formData.append("numberofunits", numberofunits);
formData.append("propertyaddress", propertyaddress);
formData.append("city", city);
formData.append("state", state);
formData.append("country", country);
formData.append("postalcode", postalcode);
formData.append("propertyfeatures", propertyfeatures);
formData.append("description", description);
formData.append("Propertyimage", propertyimage);

for (var i = 1; i <= unitIndex; i++) {
var unitname = document.getElementById(`unitname${i}`).value;
var unittype = document.getElementById(`unittype${i}`).value;
var area = document.getElementById(`area${i}`).value;
var room = document.getElementById(`room${i}`).value;
var feet = document.getElementById(`feet${i}`).value;
var rent = document.getElementById(`rent${i}`).value;
var advance = document.getElementById(`advance${i}`).value;
var frequency = document.getElementById(`frequency${i}`).value;
var checkboxes = document.querySelectorAll(`input[name="unitfeatures${i}"]:checked`);
var unitfeatures = "";
for (var j = 0; j < checkboxes.length; j++) {
unitfeatures += checkboxes[j].value;
if (j < checkboxes.length - 1) {
unitfeatures += ", ";
}
}

var unitdescription = document.getElementById(`unitdescription${i}`).value;
var unitimage = document.getElementById(`unitimage${i}`).files[0];
var addunit = 'addunit';
formData.append(`unit`, addunit);
formData.append(`unitname${i}`, unitname);
formData.append(`unittype${i}`, unittype);
formData.append(`area${i}`, area);
formData.append(`room${i}`, room);
formData.append(`feet${i}`, feet);
formData.append(`baserent${i}`, rent);
formData.append(`advance${i}`, advance);
formData.append(`frequency${i}`, frequency);
formData.append(`unitfeatures${i}`, unitfeatures);
formData.append(`unitdescription${i}`, unitdescription);
formData.append(`unitimage${i}`, unitimage);
formData.append(`unitIndex`, unitIndex);
}
var xhr = new XMLHttpRequest();
xhr.open("POST", "property1.php", true);

xhr.onreadystatechange = function() {
if (xhr.readyState === 4 && xhr.status === 200) {
    //alert(1)
document.getElementById("demo").innerHTML = xhr.responseText;
alert(xhr.responseText);
location.reload();
}
};
xhr.send(formData);
}
</script>
</body>
</html>