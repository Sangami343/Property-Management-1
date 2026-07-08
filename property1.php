<?php
$con = new mysqli("localhost", "root", "", "project");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if (isset($_POST["property"]) == 'addproperty') {
// Insert into property table
$propertyname = $_POST["propertyname"];
$propertytype = $_POST["propertytype"];
$numberofunits = $_POST["numberofunits"];
$propertyaddress = $_POST["propertyaddress"];
$city = $_POST["city"];
$state = $_POST["state"];
$country = $_POST["country"];
$postalcode = $_POST["postalcode"];
$propertyfeatures = $_POST["propertyfeatures"];
$description = $_POST["description"];
$Image = '';
$Status = 0 ;
$target_dir = "image/uploads/";
$target_file = $target_dir . basename($_FILES["Propertyimage"]["name"]);

if (move_uploaded_file($_FILES["Propertyimage"]["tmp_name"], $target_file)) {
$Image = basename($_FILES["Propertyimage"]["name"]);
} else {
echo "Error uploading the file.";
exit;
}

$sql = "INSERT INTO property (Property_Name, Property_Type, number_Of_Units, Property_Address, City, State, Country, Postal_Code, Property_Features, Description,Image,Status)
VALUES ('$propertyname', '$propertytype', '$numberofunits', '$propertyaddress', '$city', '$state', '$country', '$postalcode', '$propertyfeatures', '$description','$Image','$Status')";
$result = mysqli_query($con, $sql);
$lastInsertedID = mysqli_insert_id($con);

if ($result) {
echo "Property data inserted successfully.<br>";
echo "<img src='uploads/$Image' alt='Property Image' style='width:200px;height:auto;'><br>";
} else {
echo "Error inserting property data.";
}
}


echo "ajax";
if (isset($_POST["unit"]) && $_POST["unit"] == 'addunit') {
    
    // Assuming $lastInsertedID is defined somewhere in your code
    $property_id = $lastInsertedID;
    
    // Insert into unit table
    for ($i = 1; $i <= $_POST['unitIndex']; $i++) {
    $unitname = $_POST["unitname$i"];
    $unittype = $_POST["unittype$i"];
    $area = $_POST["area$i"];
    $room = $_POST["room$i"];
    $feet = $_POST["feet$i"];
    $baserent = $_POST["baserent$i"];
    $advance = $_POST["advance$i"];
    $frequency = $_POST["frequency$i"];
    $unitfeatures =$_POST["unitfeatures$i"];
    $unitdescription = $_POST["unitdescription$i"];
    $Status = 0 ;

    $target_dir = "image/uploads/";
    $target_file = $target_dir . basename($_FILES["unitimage$i"]["name"]);
    
    if (move_uploaded_file($_FILES["unitimage$i"]["tmp_name"], $target_file)) {
    $Image = basename($_FILES["unitimage$i"]["name"]);
    } else {
    echo "Error uploading the file.";
    exit;
    }
    
    $sql = "INSERT INTO unit (Unit_Name, Unit_Type, Area, Room, Feet, Rent,Advance, Frequency, Unit_Features, Unit_Description, Property_Id, Image,Status)
    VALUES ('$unitname', '$unittype', '$area', '$room', '$feet', '$baserent','$advance', '$frequency', '$unitfeatures', '$unitdescription', '$property_id', '$Image','$Status')";
    $result = mysqli_query($con, $sql);
    
    echo 'hai';
    if ($result) {
    echo "Unit data inserted successfully.<br>";
    echo "<img src='uploads/$Image' alt='Unit Image' style='width:200px;height:auto;'><br>";
    } else {
    echo "Error inserting unit data.";
    }
    }
    }
}
    mysqli_close($con);
?>
