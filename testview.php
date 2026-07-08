<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$con = new mysqli("localhost", "root", "", "project");

if ($con->connect_error) {
die("Connection failed: " . $con->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$action = $_POST['action'];
$documentId = $_POST['documentId'];
$userId = $_POST['User_Id'];
//echo $userId;

if ($action == 'accept') {
// Update document status to accepted
$sql = "UPDATE document SET Status = 1 WHERE id = $documentId";
if (mysqli_query($con, $sql)) {
// Fetch user email
$sql1 = "SELECT * FROM registerform WHERE id = $userId";
$result1 = mysqli_query($con, $sql1);
if ($result1) {
$row1 = mysqli_fetch_assoc($result1);
$email = $row1['Email'];
$name = $row1['User_Name'];


$sql2 = "SELECT * FROM document WHERE User_id = $userId";
$result2 = mysqli_query($con, $sql2);
if ($result2) {
$row1 = mysqli_fetch_assoc($result2);
$propertyid = $row1['Property_Id'];
$unitid = $row1['Unit_Id'];


// Send email using PHPMailer
$mail = new PHPMailer(true);

try {
// Server settings
// $mail->IsSMTP();
// $mail->SMTPAuth = true;
// $mail->Host = 'smtp.gmail.com';
// $mail->Username = 'kuttysss2610@gmail.com'; // Replace with your email
// $mail->Password = 'ipzcvjllhukagnec'; // Replace with your email password
// $mail->SMTPSecure = 'tls';
// $mail->Port = 587;

///

// $mail->IsSMTP();
// $mail->Host       = "localhost";
// $mail->Port       = 587;                  
// $mail->Username = 'kuttysss2610@gmail.com'; // Replace with your email
// $mail->Password = 'ipzcvjllhukagnec'; // Replace with your email password
// //$mail->Subject=$Fields["Subject"];
// //$mail->setfrom("automailer@4wpropertymanagement.com");

// //$mail->MsgHTML($body);
//  //$mail->AddAddress($To);

// ///
// // Recipients
// $mail->setFrom('kuttysss2610@gmail.com', 'Document Verification');
// $mail->addAddress($email);

// // Content
// $mail->isHTML(true);
// $mail->Subject = 'Document Verification';


$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'ajay19ups9025@gmail.com';
$mail->Password = 'fciziiqzjbllypfe';
$mail->SMTPSecure = 'tls'; 
$mail->Port = 587; 
 $mail->Subject="Document Verification";
 $mail->setfrom("ajay19ups9025@gmail.com");
 //$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
 
  $mail->AddAddress($email);

  $MailContent = "Dear $name,<br>Your document verification has been successfully completed.<br>Please <a href='localhost/learning/Project/payment.php?property_id=$propertyid&unit_id=$unitid'>click here</a> to proceed to the payment page.";
  // $MailContent="Dear $name,<br>Your document verification has been successfully completed.<br>Please <a href='localhost/learning/Project/payment.php?property_id=$propertyid&unit_id=$unitid'>click here</a> to proceed to the payment page.";
    $mail->MsgHTML($MailContent);
    $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
// Send email
if ($mail->send()) {
echo "Document accepted and email sent successfully.";
} else {
echo "Document accepted but email sending failed.";
}
} catch (Exception $e) {
echo "Message could not be sent. Mailer Error: " . $mail->ErrorInfo;
}
}} else {
echo "Error fetching user email: " . mysqli_error($con);
}
} else {
echo "Error updating record: " . mysqli_error($con);
}
} elseif ($action == 'deny') {
// Update document status to denied
$sql = "UPDATE document SET Status = 0 WHERE id = $documentId";
if (mysqli_query($con, $sql)) {
echo "Document denied successfully.";
} else {
echo "Error updating record: " . mysqli_error($con);
}
}
}

// Fetch all records from the database
$result = mysqli_query($con, "SELECT * FROM document WHERE Status = 2");

// Display the data in a table
echo "<style>
table {
width: 100%;
border-collapse: collapse;
}
th, td {
padding: 15px;
text-align: left;
border-bottom: 1px solid #ddd;
}
th {
background-color: #f2f2f2;
}
button.accept {
background-color: green;
color: white;
border: none;
padding: 10px 20px;
cursor: pointer;
}
button.deny {
background-color: red;
color: white;
border: none;
padding: 10px 20px;
cursor: pointer;
}
button.accept:hover, button.deny:hover {
opacity: 0.8;
}
</style>";

echo "<h2 style='text-align: center;'>Document Report</h2>";
echo "<div style='overflow-x:auto;'><table>
<tr>
<th>Name</th>
<th>Gender</th>
<th>Identity Proof</th>
<th>Address Proof</th>
<th>PAN Number</th>
<th>Business Registration Certificate</th>
<th>Fire NOC</th>
<th>Trade Licence</th>
<th>Actions</th>
</tr>";

while ($row = mysqli_fetch_assoc($result)) {
echo "<tr>
<td>{$row['Name']}</td>
<td>{$row['Gender']}</td>
<td><a href='http://localhost/learning/Project/documents/".$row['Identity_Proof']."'>identity proof</a></td>
<td><a href='http://localhost/learning/Project/documents/".$row['Address_Proof']."'>address proof</a></td>
<td>{$row['Pan_Number']}</td>
<td><a href='http://localhost/learning/Project/documents/".$row['Document_Certificate']."'>bussiness Register</a></td>
<td><a href='http://localhost/learning/Project/documents/".$row['Fire_Noc']."'>fire-noc</a></td>
<td><a href='http://localhost/learning/Project/documents/".$row['Trade_Licence']."'>tradelicence</a></td>
<td>
<form method='POST' style='display:inline;'>
<input type='hidden' name='documentId' value='{$row['id']}'>
<input type='hidden' name='User_Id' value='{$row['User_id']}'>
<button type='submit' name='action' value='accept' class='accept'>Accept</button>
</form>
<form method='POST' style='display:inline;'>
<input type='hidden' name='documentId' value='{$row['id']}'>
<button type='submit' name='action' value='deny' class='deny'>Deny</button>
</form>
</td>
</tr>";
}

echo "</table></div>";

$con->close();

?>