<?php
session_start();

$unitID = isset($_GET['unitID']) ? $_GET['unitID'] : '';
$propertyID = isset($_GET['propertyID']) ? $_GET['propertyID'] : '';
$userID = $_SESSION['id']; // Assuming user ID is stored in session
echo "<script>alert('PropertyID: $propertyID');</script>";
echo "<script>alert('Unitid: $unitID')</script>";
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
<title>Document Completed</title>
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-image: url('image/uploads/back.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.note {
    background-color: rgba(255, 255, 255, 0.95);
    border: 1px solid #ddd;
    padding: 40px 30px;
    width: 380px;
    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.2);
    border-radius: 15px;
    text-align: center;
    backdrop-filter: blur(6px);
    animation: fadeIn 0.6s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

.checkmark {
    font-size: 60px;
    color: #28a745;
    margin-bottom: 15px;
}

.note h1 {
    font-size: 26px;
    margin-bottom: 20px;
    color: #2c3e50;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.note p {
    font-size: 15px;
    color: #555;
    line-height: 1.6;
    margin-bottom: 25px;
}

button {
    padding: 12px 28px;
    background-color: #28a745;
    border: none;
    border-radius: 6px;
    color: white;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background-color: #218838;
    transform: scale(1.05);
}
</style>
</head>
<body>
<div class="note">
    <div class="checkmark">✔️</div>
    <h1>Document Completed</h1>
    <p><b>
    Thank you for uploading your information.<br>
    Your documents have been successfully submitted.<br>
    Admin is verifying your documents.<br>
    You will receive an email once verification is complete.
    </b></p>

    <form>
        <input type="hidden" name="unitID" value="<?php echo htmlspecialchars($unitID); ?>">
        <input type="hidden" name="propertyID" value="<?php echo htmlspecialchars($propertyID); ?>">
    </form>

    <!-- ✅ Button passing both IDs -->
    <button 
        type="button" 
        onclick="window.location.href='login.php?propertyID=<?php echo urlencode($propertyID); ?>&unitID=<?php echo urlencode($unitID); ?>'">
        BACK
    </button>
</div>
</body>
</html>
