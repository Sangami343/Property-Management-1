<?php
session_start();

$con = new mysqli("localhost", "root", "", "project");
if ($con->connect_error) die("Connection failed: " . $con->connect_error);

$userID = isset($_SESSION['id']) ? $_SESSION['id'] : '';

$unitID = isset($_GET['unitID']) ? $_GET['unitID'] : '';
$propertyID = isset($_GET['propertyID']) ? $_GET['propertyID'] : '';

$rent = 0;
$LeaseID = '';

$result = mysqli_query($con, "SELECT id,Advance FROM lease WHERE User_id='$userID' AND Property_Id='$propertyID' AND Unit_Id='$unitID' LIMIT 1");
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $rent = $row['Advance'];
    $LeaseID=$row['id'];
    
} else {
    echo "<script>alert('No lease record found for this user/property/unit');</script>";
}

echo "<script>alert('LeaseID: $LeaseID')</script>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Agreement Verification</title>
<style>
body {
    font-family: 'Segoe UI', Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    background: url('image/uploads/back.png') center/cover no-repeat fixed;
    min-height: 100vh;
    color: #333;
}
h1 {
    margin-top: 40px;
    font-size: 28px;
    color: #222;
    text-align: center;
}
form {
    background-color: rgba(255, 255, 255, 0.95);
    padding: 25px 30px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    width: 360px;
    margin-top: 40px;
}
label {
    display: block;
    margin-bottom: 6px;
    font-weight: bold;
    font-size: 14px;
}
input[type="text"], input[type="date"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
}
button {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 15px;
    cursor: pointer;
    transition: 0.3s;
}
button:hover {
    background-color: #45a049;
}
#demo {
    margin-top: 20px;
    font-weight: bold;
    color: green;
    text-align: center;
}
</style>
</head>
<body>

<h1>Agreement Verification</h1>

<form id="agreementForm">
    <label>Name*</label>
    <input type="text" id="name" name="name" required>

    <label>Start Date*</label>
    <input type="date" id="date" name="date" required min="<?php echo date('Y-m-d'); ?>">

    <label>End Date*</label>
    <input type="date" id="edate" name="edate" required min="<?php echo date('Y-m-d'); ?>">

    <label>Rent</label>
    <input type="text" id="rent" name="rent" value="<?php echo htmlspecialchars($rent); ?>" readonly>

    <label>Security Deposit*</label>
    <input type="text" id="deposit" name="deposit" required>

    <label>Maintenance & Repair*</label>
    <input type="text" id="Maintenance" name="Maintenance" required>

    <input type="hidden" name="unitID" id="unitID" value="<?php echo htmlspecialchars($unitID); ?>">
    <input type="hidden" name="propertyID" id="propertyID" value="<?php echo htmlspecialchars($propertyID); ?>">
    <input type="hidden" name="userID" id="userID" value="<?php echo htmlspecialchars($userID); ?>">
    <input type="hidden" name="leaseID" id="leaseID" value="<?php echo htmlspecialchars($LeaseID); ?>">

    <button type="submit">Submit</button>
</form>

<p id="demo"></p>

<script>
document.getElementById('agreementForm').addEventListener('submit', function(event){
    event.preventDefault();
    Agreement();
});

function Agreement() {
    const name = document.getElementById("name").value.trim();
    const startdate = document.getElementById("date").value;
    const enddate = document.getElementById("edate").value;
    const rent = document.getElementById("rent").value.trim();
    const deposit = document.getElementById("deposit").value.trim();
    const maintenance = document.getElementById("Maintenance").value.trim();
    const propertyID = document.getElementById("propertyID").value;
    const unitID = document.getElementById("unitID").value;
    const userID = document.getElementById("userID").value;
    const leaseID = document.getElementById("leaseID").value;
    

    if (!name || !startdate || !enddate || !deposit || !maintenance) {
        alert("Please fill all required fields!");
        return;
    }
    if (new Date(enddate) <= new Date(startdate)) {
        alert("End Date must be after Start Date.");
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "agreement1.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    const params =
        "name=" + encodeURIComponent(name) +
        "&date=" + encodeURIComponent(startdate) +
        "&edate=" + encodeURIComponent(enddate) +
        "&rent=" + encodeURIComponent(rent) +
        "&deposit=" + encodeURIComponent(deposit) +
        "&Maintenance=" + encodeURIComponent(maintenance) +
        "&propertyID=" + encodeURIComponent(propertyID) +
        "&unitID=" + encodeURIComponent(unitID) +
        "&userID=" + encodeURIComponent(userID) +
        "&leaseID=" + encodeURIComponent(leaseID);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("demo").innerHTML = xhr.responseText;
            if (xhr.responseText.includes("success")) {
                alert("Agreement saved successfully!");
                window.location.href = "login.php";
            } else {
                alert(xhr.responseText);
            }
        }
    };

    xhr.send(params);
}
</script>

</body>
</html>
