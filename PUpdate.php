<?php
$con = new mysqli("localhost", "root", "", "project");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$propertyid = $_POST['propertyid'];
$propertytype = $_POST['propertytype'];
$numberofunits = $_POST['numberofunits'];
$propertyaddress = $_POST['propertyaddress'];
$city = $_POST['city'];
$state = $_POST['state'];
$country = $_POST['country'];
$postalcode = $_POST['postalcode'];
$propertyfeatures = $_POST['propertyfeatures'];
$description = $_POST['description'];
$propertyimage = $_FILES['Propertyimage']['name'];

// Move uploaded file to a directory
move_uploaded_file($_FILES['Propertyimage']['tmp_name'], "uploads/" . $propertyimage);

$unitid = $_POST['unitid'];
$unittype = $_POST['unittype'];
$area = $_POST['area'];
$room = $_POST['room'];
$feet = $_POST['feet'];
$baserent = $_POST['baserent'];
$advance = $_POST['advance'];
$frequency = $_POST['frequency'];
$unitfeatures = $_POST['unitfeatures'];
$unitdescription = $_POST['unitdescription'];
$unitimage = $_FILES['unitimage']['name'];

// Move uploaded file to a directory
move_uploaded_file($_FILES['unitimage']['tmp_name'], "uploads/" . $unitimage);

$sql = "UPDATE property SET propertytype='$propertytype', numberofunits='$numberofunits', propertyaddress='$propertyaddress', city='$city', state='$state', country='$country', postalcode='$postalcode', propertyfeatures='$propertyfeatures', description='$description', image='$propertyimage' WHERE id='$propertyid'";
$con->query($sql);

$sql = "UPDATE unit SET unittype='$unittype', area='$area', room='$room', feet='$feet', baserent='$baserent', frequency='$frequency', unitfeatures='$unitfeatures', description='$unitdescription', image='$unitimage' WHERE id='$unitid'";
$con->query($sql);

echo "Property and Unit updated successfully!";
}
?>