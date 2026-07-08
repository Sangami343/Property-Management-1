<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$con = new mysqli("localhost", "root", "", "project");

if (isset($_GET['User_id'])) {
$user_id = $_GET['User_id'];
$sql = "UPDATE document SET Status = 3 WHERE Status = 2 AND User_id = '$user_id'";

if ($con->query($sql) === TRUE) {
$sql = "SELECT * FROM document WHERE Status = 3 AND User_id = '$user_id'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_all($result, MYSQLI_NUM);
$len = count($row);

$sql1 = "SELECT * FROM registerform WHERE id = '$user_id'";
$result1 = mysqli_query($con, $sql1);
$row1 = mysqli_fetch_all($result1, MYSQLI_NUM);
$name = $row1[0][1];
$email = $row1[0][2];

$mailcontent = "THANK YOU";

$mail = new PHPMailer(true);

try {
// Server settings
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->Host = 'smtp.gmail.com';
$mail->Username = 'kuttysss2610@gmail.com';
$mail->Password = 'ipzcvjllhukagnec';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

// Recipients
$mail->setFrom('kuttysss2610@gmail.com', 'Document');
$mail->addAddress($email, 'Document Verification');

// Content
$mail->isHTML(true);
$mail->Subject = 'Document Verification';
$mail->Body    = "DEAR, " . $name . "<br> Your document has been successfully verified.<br>" . $mailcontent;

if ($mail->send()) {
echo "document verified and email sent successfully.";

// Delete records from the document table
$deleteSql = "DELETE FROM document WHERE Status = 3 AND User_id = '$user_id'";
if ($con->query($deleteSql) === TRUE) {
echo " Records deleted successfully.";
} else {
echo " Error deleting records: " . $con->error;
}
} else {
echo "Order placed but email sending failed.";
}
} catch (Exception $e) {
echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
} else {
echo "Error updating record: " . mysqli_error($con);
}
} else {
//header('Location: view1.php');
exit(0);
}

$con->close();
?>
