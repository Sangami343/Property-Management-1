<?php
$con = new mysqli("localhost", "root", "", "project");
if (isset($_POST['id'])) {
$id = $_POST['id'];
$sql = "UPDATE unit SET Status = 1 WHERE id = $id";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_all($result, MYSQLI_NUM);
}
?>