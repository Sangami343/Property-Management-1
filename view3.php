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
<title>Registration Complete</title>
<style>
body {
font-family: Arial, sans-serif;
background-color: #f4f4f9;
display: flex;
justify-content: center;
align-items: center;
height: 100vh;
margin: 0;
background-image: url('image/uploads/back.png'); /* Correct way to set background image */
}
.note {
background-color: #fff;
border: 1px solid #ccc;
padding: 20px;
width: 300px;
box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
border-radius: 10px;
text-align: center;
}
.note h1 {
font-size: 24px;
margin-bottom: 10px;
}
.note p {
font-size: 16px;
margin: 0;
}
button {
margin-top: 20px;
padding: 10px 20px;
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
<input type="hidden" name="unitID" value="<?php echo($unitID); ?>">
<input type="hidden" name="propertyID" value="<?php echo($propertyID); ?>">
<div class="note">
<h1>Registration Completed</h1>
<p><b>Thank you for registering. Your information has been successfully submitted.</b></p>
<button type="button" onclick="window.location.href=`document2.php?propertyID=<?php echo $propertyID;?>&unitID=<?php echo $unitID; ?>`">Click to upload Document</button>
</div>
</body>
</html>