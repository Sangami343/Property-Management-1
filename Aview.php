<?php
session_start();

$con = new mysqli("localhost", "root", "", "project");
$sql = "SELECT * FROM property";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Properties</title>
<style>
body {
font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
background-color: #f0f2f5;
margin: 0;
padding: 0;
text-align: center;
}
h1 {
color: #333;
margin-top: 20px;
}
.property, .unit {
width: 90%;
margin: 20px auto;
padding: 20px;
background: #fff;
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
border-radius: 10px;
overflow: hidden;
text-align: left;
}
.property img, .unit img {
max-width: 300px;
max-height:300px;
float: inherit;
margin: 0 0 10px 10px;
border-radius: 10px;
}
.property h2, .unit h3 {
color: #007BFF;
margin-top: 0;
}
.unit h3 {
margin-top: 20px; /* Add margin to move h3 lower */
}
.property p, .unit p {
margin: 5px 0;
color: #555;
}
button {
background-color: #007BFF;
border: none;
color: white;
padding: 10px 20px;
float: right;
text-decoration: none;
display: inline-block;
font-size: 16px;
margin: 20px 0;
cursor: pointer;
border-radius: 5px;
transition: background-color 0.3s;
}
button:hover {
background-color: #0056b3;
text-align: right;

}
.container {
max-width: 1200px;
margin: 0 auto;
padding: 20px;
}
</style>
</head>
<body>
<div class="container">
<button type="submit" onclick="window.location.href='dashborad.php'">BACK</button>

<h1>Property Details</h1>
<?php
if ($result->num_rows > 0) {
while($row = $result->fetch_assoc()) {
echo "<div class='property'>";
echo "<h2>" . $row['Property_Name'] . "</h2>";
echo "<p><strong>Type:</strong> " . $row['Property_Type'] . "</p>";
echo "<p><strong>Number of Units:</strong> " . $row['number_Of_Units'] . "</p>";
echo "<p><strong>Address:</strong> " . $row['Property_Address'] . "</p>";
echo "<p><strong>City:</strong> " . $row['City'] . "</p>";
echo "<p><strong>State:</strong> " . $row['State'] . "</p>";
echo "<p><strong>Country:</strong> " . $row['Country'] . "</p>";
echo "<p><strong>Postal Code:</strong> " . $row['Postal_Code'] . "</p>";
echo "<p><strong>Features:</strong> " . $row['Property_Features'] . "</p>";
echo "<p><strong>Description:</strong> " . $row['Description'] . "</p>";
echo "<img src='image/uploads/" . $row['Image'] . "' alt='Property Image'><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";

// Fetch and display unit details for each property
$property_id = $row['Id'];
$unit_sql = "SELECT * FROM unit WHERE Property_Id = $property_id";
$unit_result = $con->query($unit_sql);
if ($unit_result->num_rows > 0) {
echo "<h3>Units:</h3>";
while($unit_row = $unit_result->fetch_assoc()) {
echo "<div class='unit'>";
echo "<h3>" . $unit_row['Unit_Name'] . "</h3>";
echo "<p><strong>Type:</strong> " . $unit_row['Unit_Type'] . "</p>";
echo "<p><strong>Area:</strong> " . $unit_row['Area'] . " sq ft</p>";
echo "<p><strong>Rooms:</strong> " . $unit_row['Room'] . "</p>";
echo "<p><strong>Feet:</strong> " . $unit_row['Feet'] . "</p>";
echo "<p><strong>Base Rent:</strong> " . $unit_row['Rent'] . "</p>";
echo "<p><strong>Frequency:</strong> " . $unit_row['Frequency'] . "</p>";
echo "<p><strong>Features:</strong> " . $unit_row['Unit_Features'] . "</p>";
echo "<p><strong>Description:</strong> " . $unit_row['Unit_Description'] . "</p>";
echo "<img src='image/uploads/" . $unit_row['Image'] . "' alt='Unit Image'>";
echo "</div>";
}
}
echo "</div>";
}
} else {
echo "<p>No properties found</p>";
}
$con->close();
?>
</div>
</body>
</html>