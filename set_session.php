<?php
session_start();

if (isset($_POST['username'])) {
    $_SESSION['id'] = $_POST['username'];
    echo "Session set for " . $_SESSION['id'];
}
?>
