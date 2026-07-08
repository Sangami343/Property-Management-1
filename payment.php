<?php
session_start();

// ✅ Check if the user is logged in
if (!isset($_SESSION['id'])) {
    echo "User not logged in";
    exit();
}

$con = new mysqli("localhost", "root", "", "project");

// ✅ Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// ✅ Use the correct session variable for user ID
//echo $userID;
 $userID = $_SESSION['id'];
// echo $userID;

$unitID = isset($_GET['unitID']) ? $_GET['unitID'] : '';
$propertyID = isset($_GET['propertyID']) ? $_GET['propertyID'] : '';

echo "<script>alert('PropertyID: $propertyID')</script>";
echo "<script>alert('UnitID: $unitID')</script>";
echo "<script>alert('UserID: $userID')</script>";

$roomRent = '';
$unitFeet = '';
$advance = '';

// ✅ Fetch unit details if unitID is provided
if (!empty($unitID)) {
    $unitID = (int)$unitID; // Sanitize to prevent SQL injection
    $sql1 = "SELECT Rent, Feet, Advance FROM unit WHERE id = $unitID";
    $result1 = mysqli_query($con, $sql1);

    if ($result1 && mysqli_num_rows($result1) > 0) {
        $row1 = mysqli_fetch_assoc($result1);
        $roomRent = $row1['Rent'];
        $unitFeet = $row1['Feet'];
        $advance = $row1['Advance'];
    }
}

// ✅ Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $comment1 = $_POST['comment'];
    $status = 1; // Assuming 1 = completed
    $propertyid = $_POST['hiddenpropertyID'];
    $unitid = $_POST['hiddenunitID'];
    $paymentMethod = $_POST['paymentMethod'];

    // ✅ Insert payment record
    $sql = "INSERT INTO payment (User_id, Property_Id, Unit_Id, Amount, Unit_Feet, Unit_Rent, Comment, Status, Pay_Type, Submit_Date) 
    VALUES ('$userID', '$propertyid', '$unitid', '$amount', '$unitFeet', '$roomRent', '$comment1', '$status', '$paymentMethod', NOW())";

    if ($con->query($sql) === TRUE) {
    echo "<script>
        alert('Payment successful!');
        window.location.href = 'lease.php?unitID=$unitid&propertyID=$propertyid';
    </script>";
}
 else {
        echo "Error: " . $con->error;
    }

    $con->close();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            background-image: url('image/uploads/back.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .back-button {
            margin-top: 15px;
            text-align: center;
            display: block;
            background-color: #0288D1;
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 4px;
        }
        .back-button:hover {
            background-color: #026aa7;
        }
    </style>
</head>
<body>
    <div class="container">
        <form id="paymentForm" method="POST">
            <h1 align="center">Payment Page</h1>

            <label for="roomRent">Room Rent:</label>
            <input type="text" id="rent" name="rent" value="<?php echo htmlspecialchars($roomRent); ?>" readonly>

            <label for="unitFeet">Unit Feet:</label>
            <input type="text" id="feet" name="feet" value="<?php echo htmlspecialchars($unitFeet); ?>" readonly>

            <label for="totalAmount">Advance Amount:</label>
            <input type="text" name="amount" id="amount" value="<?php echo htmlspecialchars($advance); ?>" readonly>

            <label for="comment">Comment:</label>
            <input type="text" name="comment" id="comment" placeholder="optional">

            <label for="paymentMethod">Payment Method:</label>
            <select id="paymentMethod" name="paymentMethod">
                <option value="Credit Card">Credit Card</option>
                <option value="Cash">Cash</option>
                <option value="Debit Card">Debit Card</option>
                <option value="UPI">UPI</option>
            </select>

            <!-- Hidden fields -->
            <input type="hidden" id="unitID" name="hiddenunitID" value="<?php echo htmlspecialchars($unitID); ?>">
            <input type="hidden" id="propertyID" name="hiddenpropertyID" value="<?php echo htmlspecialchars($propertyID); ?>">

            <button type="submit">Pay</button>
        </form>

        <!-- Back button -->
        <a href="login.php" class="back-button">Back</a>
    </div>
</body>
</html>
