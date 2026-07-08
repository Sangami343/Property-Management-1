<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$username = $_POST['username'];
$password = $_POST['password'];

$admin_username = "admin";
$admin_password = "admin123";

if ($username === $admin_username && $password === $admin_password) {
echo "Welcome Admin!";
} else {
echo "Invalid username or password.";
}
}
?>
