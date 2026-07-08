<?php
session_start();

$unitID = isset($_GET['unitID']) ? $_GET['unitID'] : '';
$propertyID = isset($_GET['propertyID']) ? $_GET['propertyID'] : '';
$userID = $_SESSION['id']; // Assuming user ID is stored in session

$con = new mysqli("localhost", "root", "", "project");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$name = '';
if ($userID) {
    $sql = "SELECT User_Name FROM registerform WHERE id = $userID";
    $result = mysqli_query($con, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['User_Name'];
    }
}

$con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document Verification</title>
<style>
body {
font-family: Arial, sans-serif;
background-color: #f4f4f4;
margin: 0;
padding: 0;
display: flex;
flex-direction: column;
min-height: 100vh;
background-size: cover;
background-repeat: no-repeat;
background-position: center;
}
header, footer {
background-color: rgba(0, 0, 255, 0.8);
color: #fff;
text-align: center;
padding: 10px 0;
position: fixed;
width: 100%;
z-index: 250;
}
header {
top: 0;
font-size: 10px;
font-weight: bold;
}
footer {
bottom: 0;
font-size: 10px;
font-weight: bold;
}
.container {
background-color: #fff;
padding: 60px;
border-radius: 3px;
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
width: 80%;
max-width: 1000px;
margin: 100px auto 60px auto;
flex: 1;
}
h1 {
text-align: center;
color: white;
margin-bottom: 20px;
}
label {
display: block;
margin-bottom: 8px;
color: black;
font-weight: bold;
}
input[type="text"],
input[type="file"] {
width: 100%;
padding: 10px;
margin-bottom: 15px;
border: 1px solid black;
border-radius: 4px;
box-sizing: border-box;
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
</style>
</head>
<body>
<header>
<h1>Document Verification</h1>
</header>
<div class="container">
<form id="verificationForm" onsubmit="Verification(event)">
<label for="name">Name*</label>
<input type="text" id="name" name="name" value="<?php echo $name; ?>" readonly required>

<label for="gender">Gender*</label>
<select id="gender" name="gender" required>
<option value="Male">Male</option>
<option value="Female">Female</option>
<option value="Other">Other</option>
</select><br><br>

<label for="proof">Identity Proof*</label>
<input type="file" id="proof" name="proof" accept=".pdf" required>

<label for="address">Address Proof*</label>
<input type="file" id="address" name="address" accept=".pdf" required>

<label for="number">PAN Number*</label>
<input type="text" id="number" name="number" required>

<label for="certificate">Business Registration Certificate*</label>
<input type="file" id="certificate" name="certificate" accept=".pdf" required>

<label for="fire">Fire NOC*</label>
<input type="file" id="fire" name="fire" accept=".pdf" required>

<label for="trade">Trade Licence*</label>
<input type="file" id="trade" name="trade" accept=".pdf" required>

<input type="hidden" id="unitID" name="unitID" value="<?php echo($unitID); ?>">
<input type="hidden" id="propertyID" name="propertyID" value="<?php echo($propertyID); ?>">

<button type="submit">Submit</button>
</form>
<div id="demo"></div>
</div>
<footer>
<p>© 2024 Company Name. All rights reserved.</p>
</footer>
<script>
function Verification(event) {
    event.preventDefault(); // Prevent the default form submission

    var form = document.getElementById('verificationForm');
    var formData = new FormData(form);

    var unitID = document.getElementById('unitID').value;
    var propertyID = document.getElementById('propertyID').value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "document1.php", true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("demo").innerHTML = xhr.responseText;
            // Redirect with unitID and propertyID
            window.location.href = 'view6.php?unitID=' + encodeURIComponent(unitID) + '&propertyID=' + encodeURIComponent(propertyID);
        }
    };

    xhr.send(formData);
}
</script>
</body>
</html>
