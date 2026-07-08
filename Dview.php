<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$unitID = isset($_GET['unitID']) ? $_GET['unitID'] : '';
$propertyID = isset($_GET['propertyID']) ? $_GET['propertyID'] : '';
$userID = $_SESSION['id']; // Assuming user ID is stored in session
echo "<script>alert('PropertyID: $propertyID')</script>";
echo "<script>alert('UnitID: $unitID')</script>";
echo "<script>alert('UserID: $userID')</script>";

$con = new mysqli("localhost", "root", "", "project");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $documentId = $_POST['documentId'];
    $userId = $_POST['User_Id'];

    if ($action == 'accept') {
        // ✅ First check if this document is already accepted
        $check = mysqli_query($con, "SELECT Status FROM document WHERE id = $documentId");
        $doc = mysqli_fetch_assoc($check);

        if ($doc['Status'] == 1) {
            // Already accepted — no need to send mail again
            // echo "<script>alert('This document was already accepted. Email will not be resent.');</script>";
        } else {
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
                        $row2 = mysqli_fetch_assoc($result2);
                        $propertyid = $row2['Property_Id'];
                        $unitid = $row2['Unit_Id'];

                        // Send email using PHPMailer
                        $mail = new PHPMailer(true);

                        try {
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'jackkutty2003@gmail.com'; // your email
                            $mail->Password = 'ihar pkkt pcuz efua'; // your app password
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                            $mail->Port = 465;

                            $mail->SMTPOptions = array(
                                'ssl' => array(
                                    'verify_peer' => false,
                                    'verify_peer_name' => false,
                                    'allow_self_signed' => true
                                )
                            );

                            $mail->setFrom('jackkutty2003@gmail.com', 'Document Verification');
                            $mail->addAddress($email);

                            $mail->isHTML(true);
                            $mail->Subject = 'Document Verification';
                            $mail->Body = "Dear $name,<br>Your document verification has been <b>successfully completed</b>.<br>Please <a href='http://localhost/learning/Project/payment.php?propertyID=$propertyID  &unitID=$unitID'>click here</a> to proceed to the payment page.";

                            if ($mail->send()) {
                                echo "<script>alert('Document accepted and email sent successfully.');</script>";
                            } else {
                                echo "<script>alert('Document accepted but email sending failed.');</script>";
                            }
                        } catch (Exception $e) {
                            echo "<script>alert('Mailer Error: " . $mail->ErrorInfo . "');</script>";
                        }
                    } else {
                        echo "<script>alert('Error fetching document details: " . mysqli_error($con) . "');</script>";
                    }
                } else {
                    echo "<script>alert('Error fetching user email: " . mysqli_error($con) . "');</script>";
                }
            } else {
                echo "<script>alert('Error updating record: " . mysqli_error($con) . "');</script>";
            }
        }
    } elseif ($action == 'deny') {
        // Update document status to denied
        $sql = "UPDATE document SET Status = 0 WHERE id = $documentId";
        if (mysqli_query($con, $sql)) {
            $sql1 = "SELECT * FROM registerform WHERE id = $userId";
            $result1 = mysqli_query($con, $sql1);
            if ($result1) {
                $row1 = mysqli_fetch_assoc($result1);
                $email = $row1['Email'];
                $name = $row1['User_Name'];

                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'jackkutty2003@gmail.com';
                    $mail->Password = 'ihar pkkt pcuz efua';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port = 465;

                    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );

                    $mail->setFrom('jackkutty2003@gmail.com', 'Document Verification');
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = 'Document Rejected';
                    $mail->Body = "Dear $name,<br>Your document has been <b>rejected</b> due to mistakes or missing information.<br>Please re-upload your documents and ensure all information is correct.";

                    if ($mail->send()) {
                        echo "<script>alert('Document denied and email sent successfully.');</script>";
                    } else {
                        echo "<script>alert('Document denied but email sending failed.');</script>";
                    }
                } catch (Exception $e) {
                    echo "<script>alert('Mailer Error: " . $mail->ErrorInfo . "');</script>";
                }
            } else {
                echo "<script>alert('Error fetching user email: " . mysqli_error($con) . "');</script>";
            }
        } else {
            echo "<script>alert('Error updating record: " . mysqli_error($con) . "');</script>";
        }
    }
}

// Fetch all pending documents
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
    <td><a href='http://localhost/learning/Project/documents/{$row['Identity_Proof']}'>identity proof</a></td>
    <td><a href='http://localhost/learning/Project/documents/{$row['Address_Proof']}'>address proof</a></td>
    <td>{$row['Pan_Number']}</td>
    <td><a href='http://localhost/learning/Project/documents/{$row['Document_Certificate']}'>business Register</a></td>
    <td><a href='http://localhost/learning/Project/documents/{$row['Fire_Noc']}'>fire-noc</a></td>
    <td><a href='http://localhost/learning/Project/documents/{$row['Trade_Licence']}'>trade licence</a></td>
    <td>
    <form method='POST' style='display:inline;'>
        <input type='hidden' name='documentId' value='{$row['id']}'>
        <input type='hidden' name='User_Id' value='{$row['User_id']}'>
        <button type='submit' name='action' value='accept' class='accept'>Accept</button>
    </form>
    <form method='POST' style='display:inline;'>
        <input type='hidden' name='documentId' value='{$row['id']}'>
        <input type='hidden' name='User_Id' value='{$row['User_id']}'>
        <button type='submit' name='action' value='deny' class='deny'>Deny</button><br><br>

    </form>
    </td>
    </tr>";
}

echo "</table></div>";

$con->close();
?>
