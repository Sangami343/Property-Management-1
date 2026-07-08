<?php
session_start();
$con = new mysqli("localhost", "root", "", "project");
if ($con->connect_error) die("Connection failed: " . $con->connect_error);

/* ------------------- AJAX: Fetch Units ------------------- */
if (isset($_GET['getUnits'])) {
    $property_id = intval($_GET['getUnits']);
    $units = mysqli_query($con, "SELECT id AS unit_id, Unit_Name FROM unit WHERE Property_Id = $property_id");
    $data = [];
    while ($row = mysqli_fetch_assoc($units)) {
        $data[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}


/* ------------------- TERMINATE BUTTON ------------------- */
if (isset($_POST['terminate_lease'])) {
    $property_id = intval($_POST['property_id']);
    $unit_id = intval($_POST['unit_id']);

    // Get active lease ID
    $leaseResult = mysqli_query($con, "
        SELECT id FROM lease 
        WHERE Property_Id='$property_id' AND Unit_Id='$unit_id' AND Status=0 LIMIT 1
    ");

    if ($leaseResult && mysqli_num_rows($leaseResult) > 0) {
        $lease = mysqli_fetch_assoc($leaseResult);
        $lease_id = $lease['id'];

        // Update lease and optionally agreement
        mysqli_query($con, "UPDATE lease SET Status=1 WHERE id='$lease_id'");
        // mysqli_query($con, "UPDATE agreement SET Status=1 WHERE lease_id='$lease_id'");

        echo "<script>alert('Lease terminated successfully!');</script>";
    } else {
        echo "<script>alert('No active lease found for this property and unit!');</script>";
    }
}

/* ------------------- Fetch Agreement Info ------------------- */
$property_id = isset($_GET['property_id']) ? intval($_GET['property_id']) : 0;
$unit_id = isset($_GET['unit_id']) ? intval($_GET['unit_id']) : 0;
$agreementData = [];

if ($property_id && $unit_id) {
    $query = mysqli_query($con, "
        SELECT 
            p.Property_Name,
            u.Unit_Name,
            l.id AS Lease_ID,
            l.Status
        FROM lease l
        JOIN property p ON l.Property_Id = p.id
        JOIN unit u ON l.Unit_Id = u.id
        WHERE l.Property_Id=$property_id AND l.Unit_Id=$unit_id AND l.Status=0
        LIMIT 1
    ");

    if ($query && mysqli_num_rows($query) > 0) {
        $agreementData = mysqli_fetch_assoc($query);
    }
}

/* ------------------- Fetch all properties ------------------- */
$propertyQuery = mysqli_query($con, "SELECT id, Property_Name FROM property");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Lease and Agreement Management</title>
<style>
body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #8EC5FC, #E0C3FC);
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}
.container {
  background: white;
  padding: 40px;
  border-radius: 15px;
  width: 550px;
  text-align: center;
  box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}
select, button {
  width: 100%;
  padding: 12px;
  margin: 10px 0;
  border-radius: 8px;
  border: 1px solid #ccc;
  font-size: 15px;
}
button {
  color: #fff;
  border: none;
  cursor: pointer;
  transition: all 0.3s ease;
}
button.accept {
  background-color: #28a745;
}
button.accept:hover {
  background-color: #218838;
}
button.terminate {
  background-color: #dc3545;
}
button.terminate:hover {
  background-color: #b02a37;
}
.details {
  margin-top: 15px;
  background: #f8f9fa;
  border-radius: 8px;
  padding: 15px;
  display: none;
  text-align: left;
}
h2 {
  color: #333;
  margin-bottom: 20px;
}
</style>
</head>
<body>
<div class="container">
  <h2>Lease Management</h2>

  <form method="POST" id="leaseForm">
    <label><b>Select Property:</b></label>
    <select name="property_id" id="propertyDropdown" required onchange="loadUnits(this.value)">
      <option value="">-- Choose Property --</option>
      <?php while ($p = mysqli_fetch_assoc($propertyQuery)) { ?>
        <option value="<?php echo $p['id']; ?>" <?php if ($property_id == $p['id']) echo 'selected'; ?>>
          <?php echo htmlspecialchars($p['Property_Name']); ?>
        </option>
      <?php } ?>
    </select>

    <label><b>Select Unit:</b></label>
    <select name="unit_id" id="unitDropdown" required onchange="loadAgreement()" <?php echo $property_id ? '' : 'disabled'; ?>>
      <option value="">-- Choose Unit --</option>
    </select>

    <div class="details" id="detailsBox">
      <p><b>Property:</b> <span id="propertyName"></span></p>
      <p><b>Unit:</b> <span id="unitName"></span></p>
      <p><b>Lease Status:</b> <span id="agreementDetails"></span></p>

      <button type="button" class="accept" onclick="acceptLease()">Accept</button>
      <button type="submit" name="terminate_lease" class="terminate" onclick="return confirmTerminate()">Terminate</button>
    </div>
  </form>
</div>

<script>
function loadUnits(propertyID) {
  if (!propertyID) return;
  fetch("?getUnits=" + propertyID)
    .then(res => res.json())
    .then(data => {
      let unitDropdown = document.getElementById('unitDropdown');
      unitDropdown.innerHTML = '<option value="">-- Choose Unit --</option>';
      data.forEach(u => {
        unitDropdown.innerHTML += `<option value="${u.unit_id}">${u.Unit_Name}</option>`;
      });
      unitDropdown.disabled = false;
    });
}

function loadAgreement() {
  let propertyID = document.getElementById('propertyDropdown').value;
  let unitID = document.getElementById('unitDropdown').value;
  if (!propertyID || !unitID) return;
  window.location.href = "?property_id=" + propertyID + "&unit_id=" + unitID;
}

<?php if (!empty($agreementData)) { ?>
document.addEventListener("DOMContentLoaded", function() {
  document.getElementById('detailsBox').style.display = 'block';
  document.getElementById('propertyName').innerText = "<?= addslashes($agreementData['Property_Name']); ?>";
  document.getElementById('unitName').innerText = "<?= addslashes($agreementData['Unit_Name']); ?>";
  document.getElementById('agreementDetails').innerText = "Active";
});
<?php } ?>

function acceptLease() {
  alert("Lease Accepted Successfully!");
}
function confirmTerminate() {
  return confirm("Are you sure you want to terminate this lease?");
}
</script>
</body>
</html>
