<?php
session_start();

$unitID = isset($_GET['unitID']) ? $_GET['unitID'] : '';
$propertyID = isset($_GET['propertyID']) ? $_GET['propertyID'] : '';
$userID = $_SESSION['id'];
echo "<script>alert($unitID)</script>";
echo "<script>alert($propertyID)</script>";
echo "<script>alert($userID)</script>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Registration</title>
<style>
body {
font-family: Arial, sans-serif;
background-color: #f4f4f4;
margin: 0;
padding: 0;
display: flex;
justify-content: center;
align-items: center;
height: 150vh;
background-image: url('image/uploads/back.png'); /* Correct way to set background image */
}
.container {
background-color: #fff;
padding: 20px;
border-radius: 5px;
box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
width: 350px;
}
h1 {
text-align: center;
color: #333;
}
label {
display: block;
margin-bottom: 8px;
color: #555;
}
input[type="text"],
input[type="email"],
input[type="password"],
input[type="tel"] {
width: 100%;
padding: 5px;
margin-bottom: 10px;
border: 1px solid #ccc;
border-radius: 4px;
}
button {
width: 100%;
padding: 10px;
background-color: #28a745;
border: none;
border-radius: 4px;
color: #fff;
font-size: 16px;
cursor: pointer;
}
button:hover {
background-color: #218838;
}
.error {
color: red;
margin-bottom: 10px;
}
</style>
</head>
<body>
<div class="container">
<h1>Tenant Old Details</h1>
<form id="registration" onsubmit="login(); return false;">
<label for="unitname">Unitname:</label>
<input type="text" id="unitname" name="unitname" required>

<label for="location">Location:</label>
<input type="text" id="location" name="location" required>

<label for="squarefeet">Squarefeet:</label>
<input type="text" id="feet" name="feet" required>

<label for="scale">Scale:</label>
<input type="text" id="scale" name="scale" required><br><br>

<input type="hidden"  id="unitID"  name="unitID" value="<?php echo($unitID); ?>">
<input type="hidden"  id="propertyID"  name="propertyID" value="<?php echo($propertyID); ?>">

<button type="submit">Submit</button>
</form>
<div id="demo"></div>
</div>
<script>
function login() {
// alert("sangami");
var unitname = document.getElementById("unitname").value;
var location = document.getElementById("location").value;
var squarefeet = document.getElementById("feet").value;
var scale = document.getElementById("scale").value;
var unitID = document.getElementById("unitID").value;
var propertyID = document.getElementById("propertyID").value;

var xhr = new XMLHttpRequest();
var val = "unitname=" + unitname +
"&location=" + location +
"&feet=" + squarefeet +
"&scale=" + scale;

xhr.open("POST", "view4.php", true);
xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

xhr.onreadystatechange = function() {
if (xhr.readyState == 4 && xhr.status == 200) {
document.getElementById("demo").innerHTML = xhr.responseText;
// alert(xhr.responseText);
window.location.href = "view3.php?propertyID="+propertyID+"&unitID="+unitID;
}
};

xhr.send(val);
}
</script>
</body>
</html>