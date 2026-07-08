<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    echo "User not logged in";
    exit();
}

$con = new mysqli("localhost", "root", "", "project");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$userID = $_SESSION['id'];
$unitID = isset($_GET['unitID']) ? $_GET['unitID'] : '';
$propertyID = isset($_GET['propertyID']) ? $_GET['propertyID'] : '';

echo "<script>alert('PropertID: $propertyID')</script>";
echo "<script>alert('UnitID: $unitID')</script>";
echo "<script>alert('UserID: $userID')</script>";

$propertyName = '';
$unitName = '';
$roomRent = '';
$tenantName = '';
$advance = '';

if ($unitID) {
    $sql = "SELECT u.Rent, u.Advance, u.Unit_Name, p.Property_Name, r.User_Name 
            FROM unit u 
            JOIN property p ON u.Property_Id = p.id 
            JOIN registerform r ON r.id = $userID
            WHERE u.id = $unitID";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $roomRent = $row['Rent'];
        $advance = $row['Advance'];
        $unitName = $row['Unit_Name'];
        $propertyName = $row['Property_Name'];
        $tenantName = $row['User_Name'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $startDate = $_POST['start_date'];

    $question1 = isset($_POST['question1']) ? $_POST['question1'] : 'Disagree';
    $question2 = isset($_POST['question2']) ? $_POST['question2'] : 'Disagree';
    $question3 = isset($_POST['question3']) ? $_POST['question3'] : 'Disagree';
    $question4 = isset($_POST['question4']) ? $_POST['question4'] : 'Disagree';

    $calculatedAdvance = $roomRent * 1.5;

    $sql = "INSERT INTO lease (User_Id, Property_Id, Unit_Id, Start_Date, Rent, Advance, question1, question2, question3, question4, Submit_Date, Status) 
            VALUES ('$userID', '$propertyID', '$unitID', '$startDate', '$roomRent', '$calculatedAdvance', '$question1', '$question2', '$question3', '$question4', NOW(), 0)";

    if ($con->query($sql) === TRUE) {
        echo "<script>
            alert('Lease submitted successfully!'); 
            window.location.assign('agreement.php?propertyID=' + encodeURIComponent('$propertyID') + '&unitID=' + encodeURIComponent('$unitID'));
        </script>";
    } else {
        echo 'Error: ' . $con->error;
    }

    $con->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Lease and Agreement Form</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
}
.container {
    background-color: #fff;
    padding: 40px 50px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    width: 600px;
}
h1 {
    text-align: center;
    color: #333;
    margin-bottom: 30px;
}
label {
    display: block;
    margin-bottom: 8px;
    color: #555;
    font-weight: bold;
}
input[type="text"],
input[type="date"],
select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
button {
    width: 100%;
    padding: 15px;
    background-color: #28a745;
    border: none;
    border-radius: 5px;
    color: #fff;
    font-size: 18px;
    cursor: pointer;
}
button:hover {
    background-color: #218838;
}
.checkbox-group {
    margin-bottom: 15px;
}
.checkbox-group label {
    display: inline-block;
    margin-right: 10px;
}
p {
    font-size: 16px;
    color: #333;
}
</style>
</head>
<body>
<div class="container">
<h1>Lease and Agreement Form</h1>
<form id="leaseForm" method="POST">

    <p><strong>Property Name:</strong> <?php echo htmlspecialchars($propertyName); ?></p>
    <p><strong>Unit Name (Tenant Name):</strong> <?php echo htmlspecialchars($unitName) . ' (' . htmlspecialchars($tenantName) . ')'; ?></p>
    <p><strong>Rent:</strong> <?php echo htmlspecialchars($roomRent); ?></p>
    <p><strong>Advance:</strong> <?php echo htmlspecialchars($advance); ?></p>

    <label for="start_date">Start Date:</label>
    <input type="date" id="start_date" name="start_date" required>

    <div class="checkbox-group">
        <label>Do you agree to the terms and conditions?</label><br>
        <input type="radio" name="question1" value="Agree"> Agree
        <input type="radio" name="question1" value="Disagree"> Disagree
    </div>

    <div class="checkbox-group">
        <label>Have you vacated a house before?</label><br>
        <input type="radio" name="question2" value="Agree"> Agree
        <input type="radio" name="question2" value="Disagree"> Disagree
    </div>

    <div class="checkbox-group">
        <label>If yes, did you inform 3 months in advance?</label><br>
        <input type="radio" name="question3" value="Agree"> Agree
        <input type="radio" name="question3" value="Disagree"> Disagree
    </div>

    <div class="checkbox-group">
        <label>Do you agree to deduct the rent from the advance if vacated?</label><br>
        <input type="radio" name="question4" value="Agree"> Agree
        <input type="radio" name="question4" value="Disagree"> Disagree
    </div>

    <input type="hidden" name="unitID" value="<?php echo htmlspecialchars($unitID); ?>">
    <input type="hidden" name="propertyID" value="<?php echo htmlspecialchars($propertyID); ?>">

    <button type="submit">Submit</button>
</form>
</div>

<script>
// Prevent selecting past dates
document.addEventListener("DOMContentLoaded", function() {
    const dateInput = document.getElementById("start_date");
    const today = new Date().toISOString().split("T")[0];
    dateInput.setAttribute("min", today);
});
</script>
</body>
</html>
