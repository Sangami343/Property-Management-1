
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Maintenance Request</title>
<style>
body {
font-family: Arial, sans-serif;
background-color: #f4f4f4;
margin: 0;
padding: 0;
text-align: center;
background-image: url('image/uploads/back.png'); /* Correct way to set background image */
}
.container {
max-width: 600px;
margin: 50px auto;
padding: 20px;
background: #fff;
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
border-radius: 10px;
}
h1 {
color: #333;
}
form {
display: flex;
flex-direction: column;
}
label {
margin: 10px 0 5px;
text-align: left;
}
input, select, textarea {
padding: 10px;
margin-bottom: 20px;
border: 1px solid #ccc;
border-radius: 5px;
}
button {
background-color: #007BFF;
border: none;
color: white;
padding: 10px 20px;
text-align: center;
text-decoration: none;
display: inline-block;
font-size: 16px;
cursor: pointer;
border-radius: 5px;
transition: background-color 0.3s;
}
button:hover {
background-color: #0056b3;
}
</style>
</head>
<body>
<div class="container">
<h1>Maintenance Request</h1>
<form id="maintenanceForm" enctype="multipart/form-data">
<label for="maintenanceType">Maintenance Type</label>
<select id="maintenanceType" name="maintenanceType" required>
<option value="">Select Type</option>
<option value="Electrical">Electrical</option>
<option value="Plumbing">Plumbing</option>
<option value="HVAC">HVAC</option>
<option value="General">General</option>
</select>

<label for="priority">Priority</label>
<select id="priority" name="priority" required>
<option value="">Select Priority</option>
<option value="High">High</option>
<option value="Low">Low</option>
</select>

<label for="comments">Comments</label>
<textarea id="comments" name="comments" required></textarea>

<label for="image">Upload Image</label>
<input type="file" id="image" name="image" required>

<button type="button" onclick="submitForm()">Submit</button>
</form>
</div>

<script>
function submitForm() {
var maintenanceType = document.getElementById('maintenanceType').value;
var priority = document.getElementById('priority').value;
var comments = document.getElementById('comments').value;
var image = document.getElementById('image').files[0];

if (maintenanceType && priority && comments && image) {
var formData = new FormData();
formData.append('maintenanceType', maintenanceType);
formData.append('priority', priority);
formData.append('comments', comments);
formData.append('image', image);

var xhr = new XMLHttpRequest();
xhr.open("POST", "maintenance1.php", true);
xhr.onreadystatechange = function() {
if (xhr.readyState == 4 && xhr.status == 200) {
alert("Maintenance request submitted successfully!");
document.getElementById('maintenanceForm').reset();
}
};
xhr.send(formData);
} else {
alert("Please fill in all fields.");
}
}
</script>
</body>
</html>