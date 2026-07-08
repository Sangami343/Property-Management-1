<?php
session_start();

$con = new mysqli("localhost", "root", "", "project");

// Check connection
if ($con->connect_error) {
die("Connection failed: " . $con->connect_error);
}

$sql = "SELECT * FROM property";
$result = $con->query($sql);
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
.card {
width: 90%;
margin: 20px auto;
padding: 20px;
background: #fff;
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
border-radius: 10px;
overflow: hidden;
text-align: left;
}
.card img {
max-width: 300px;
max-height: 300px;
float: right;
margin: 0 0 10px 10px;
border-radius: 10px;
}
.card h3, .card h4 {
color: #007BFF;
margin-top: 0;
}
.card p {
margin: 5px 0;
color: #555;
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
margin: 20px 0;
cursor: pointer;
border-radius: 5px;
transition: background-color 0.3s;
}
button:hover {
background-color: #0056b3;
}
.container {
max-width: 1200px;
margin: 0 auto;
padding: 20px;
}
.top-right-buttons {
position: absolute;
top: 20px;
right: 20px;
}
.top-right-buttons button {
margin-left: 10px;
}
</style>
</head>
<body>
<div class="top-right-buttons">
  <button type="button" onclick="confirmLogout()">Log Out</button>
</div>

<div class="container">
  <h1>WELCOME TENANT.....!</h1>
  <h2>Property Details</h2>

  <?php
  if ($result->num_rows > 0) {
      $count = 1; // Counter for property numbering
      while($row = $result->fetch_assoc()) {
          echo "<div class='card'>";
          echo "<h3><span class='property-number'>" . $count . "</span>" . htmlspecialchars($row ['Property_Name']) . "</h3>";
          echo "<p><strong>Type:</strong> " . htmlspecialchars($row['Property_Type']) . "</p>";
          echo "<p><strong>Number of Units:</strong> " . htmlspecialchars($row['number_Of_Units']) . "</p>";
          echo "<p><strong>Address:</strong> " . htmlspecialchars($row['Property_Address']) . "</p>";
          echo "<p><strong>City:</strong> " . htmlspecialchars($row['City']) . "</p>";
          echo "<p><strong>State:</strong> " . htmlspecialchars($row['State']) . "</p>";
          echo "<p><strong>Country:</strong> " . htmlspecialchars($row['Country']) . "</p>";
          echo "<p><strong>Postal Code:</strong> " . htmlspecialchars($row['Postal_Code']) . "</p>";
          echo "<p><strong>Features:</strong> " . htmlspecialchars($row['Property_Features']) . "</p>";
          echo "<p><strong>Description:</strong> " . htmlspecialchars($row['Description']) . "</p>";
          echo "<img src='image/uploads/" . htmlspecialchars($row['Image']) . "' alt='Property Image'><br><br>";

          // Fetch and display unit details for each property
          $property_id = $row['Id'];
          $unit_sql = "SELECT * FROM unit WHERE Property_Id = $property_id";
          $unit_result = $con->query($unit_sql);

          if ($unit_result->num_rows > 0) {
              echo "<h4>Units:</h4>";
              while($unit_row = $unit_result->fetch_assoc()) {
                  echo "<div class='unit-card'>";
                  echo "<h4>" . htmlspecialchars($unit_row['Unit_Name']) . "</h4>";
                  echo "<p><strong>Type:</strong> " . htmlspecialchars($unit_row['Unit_Type']) . "</p>";
                  echo "<p><strong>Area:</strong> " . htmlspecialchars($unit_row['Area']) . " sq ft</p>";
                  echo "<p><strong>Rooms:</strong> " . htmlspecialchars($unit_row['Room']) . "</p>";
                  echo "<p><strong>Feet:</strong> " . htmlspecialchars($unit_row['Feet']) . "</p>";
                  echo "<p><strong>Base Rent:</strong> " . htmlspecialchars($unit_row['Rent']) . "</p>";
                  echo "<p><strong>Advance:</strong> " . htmlspecialchars($unit_row['Advance']) . "</p>";
                  echo "<p><strong>Frequency:</strong> " . htmlspecialchars($unit_row['Frequency']) . "</p>";
                  echo "<p><strong>Features:</strong> " . htmlspecialchars($unit_row['Unit_Features']) . "</p>";
                  echo "<p><strong>Description:</strong> " . htmlspecialchars($unit_row['Unit_Description']) . "</p>";
                  echo "<img src='image/uploads/" . htmlspecialchars($unit_row['Image']) . "' alt='Unit Image'><br><br>";
                  echo "<button type='button' onclick='registerFunction(" . $unit_row['Id'] . ", " . $property_id . ")'>Register</button>";
                  echo "</div>";
              }
          }
          echo "</div>";
          $count++;
      }
  } else {
      echo "<p>No properties found</p>";
  }
  $con->close();
  ?>
</div>
<script>
function registerFunction(unitID, propertyID) {
if (confirm("Are you sure you want to register?")) {
window.location.href = 'view2.php?unitID=' + unitID + '&propertyID=' + propertyID; // Redirect to the registration page with unitID and propertyID
}
}

function confirmLogout() {
if (confirm("Are you sure you want to log out?")) {
window.location.href = 'login.php';
}
}
</script>
</body>
</html>