<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if (isset($_POST['handled_unit'])) {
$unitID = $_POST['unitID'];
$propertyID = $_POST['propertyID'];
if ($_POST['handled_unit'] == 'yes') {
header('Location: view5.php?unitID=' . $unitID . '&propertyID=' . $propertyID);
exit();
} else {
header('Location: document.php?unitID=' . $unitID . '&propertyID=' . $propertyID);
exit();
}
}
}

$unitID = isset($_GET['unitID']) ? $_GET['unitID'] : '';
$propertyID = isset($_GET['propertyID']) ? $_GET['propertyID'] : '';
echo $unitID;
echo $propertyID;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>
<style>
body {
font-family: Arial, sans-serif;
background-color: #f4f4f4;
margin: 0;
padding: 0;
display: flex;
justify-content: center;
align-items: center;
height: 100vh;
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
input[type="radio"] {
margin-right: 10px;
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
<div class="container">
<h1>Register</h1>
<form method="post">
<p><b>*Have you handled a unit before?*</b></p>
<input type="radio" name="handled_unit" value="yes" required> Yes
<input type="radio" name="handled_unit" value="no" required> No<br><br>
<input type="hidden" name="unitID" value="<?php echo ($unitID); ?>">
<input type="hidden" name="propertyID" value="<?php echo ($propertyID); ?>">
<button type="submit" name="submit">Next</button>
</form>
</div>
</body>
</html>