<?php
session_start();

$unitID = isset($_GET['unitID']) ? $_GET['unitID'] : '';
$propertyID = isset($_GET['propertyID']) ? $_GET['propertyID'] : '';
$userID = $_SESSION['id']; // Assuming user ID is stored in session
echo "<script>alert('PropertyID: $propertyID');</script>";
echo "<script>alert('unitID: $unitID')</script>";
echo "<script>alert('userID: $userID')</script>";

$con = new mysqli("localhost", "root", "", "project");
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>
<style>
/* General body layout */
body {
  margin: 0;
  padding: 0;
  font-family: 'Poppins', Arial, sans-serif;
  background: linear-gradient(135deg, #74ABE2, #5563DE);
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: stretch;
}

/* Logout button container */
.logout-container {
  text-align: right;
  padding: 20px 40px;
  background: rgba(255, 255, 255, 0.1);
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

/* Logout button styling */
.logout-container button {
  background-color: #ff4b5c;
  border: none;
  color: white;
  padding: 10px 22px;
  font-size: 15px;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 3px 8px rgba(0,0,0,0.2);
}
.logout-container button:hover {
  background-color: #d93d4d;
  transform: scale(1.05);
}

/* Center section for dashboard */
.dashboard-container {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
}

/* Dashboard box styling */
.dashboard-card {
  background-color: #fff;
  border-radius: 15px;
  padding: 40px 50px;
  text-align: center;
  width: 400px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.2);
  animation: fadeIn 0.8s ease;
}

/* Smooth fade-in animation */
@keyframes fadeIn {
  from {opacity: 0; transform: translateY(30px);}
  to {opacity: 1; transform: translateY(0);}
}

/* Heading style */
h1 {
  color: #333;
  margin-bottom: 35px;
  font-size: 28px;
  letter-spacing: 1px;
}

/* Dashboard buttons */
button {
  background-color: #007BFF;
  border: none;
  color: white;
  padding: 14px 32px;
  font-size: 15px;
  margin: 10px 0;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.3s ease;
  width: 280px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}
button:hover {
  background-color: #0056b3;
  transform: scale(1.05);
}
button:active {
  transform: scale(0.98);
}

/* Centering the content */
center {
  margin-top: 20px;
}
</style>
</head>
<body>
<div class="logout-container">
  <button type="button" onclick="confirmLogout()">Log Out</button>
</div>

<form>
  <input type="hidden" name="unitID" value="<?php echo htmlspecialchars($unitID); ?>">
  <input type="hidden" name="propertyID" value="<?php echo htmlspecialchars($propertyID); ?>">
</form>

<center>
  <div class="dashboard-card">
    <h1>DASHBOARD...!</h1>
    <button type="submit" onclick="window.location.href='property.php'">ADD PROPERTY & UNIT</button><br>
    <button type="submit" onclick="window.location.href='Update.php'">UPDATE PROPERTY & UNIT</button><br>
    <button type="submit" onclick="window.location.href='delete.php'">DELETE PROPERTY & UNIT</button><br>
    <button type="submit" onclick="window.location.href='Aview.php'">VIEW PROPERTY & UNIT</button><br>
    <button type="button" onclick="window.location.href='Dview.php?propertyID=<?php echo $propertyID; ?>&unitID=<?php echo $unitID; ?>'">TENANT DOCUMENTS REPORT</button><br>
    <button type="submit" onclick="window.location.href='Terminate.php'">TERMINATE LEASE & AGREEMENT</button>
  </div>
</center>

<script>
function confirmLogout() {
  if (confirm("Are you sure you want to log out?")) {
    window.location.href = 'logout.php';
  }
}
</script>
</body>
</html>
