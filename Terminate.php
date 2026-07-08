<?php
session_start();
$con = new mysqli("localhost", "root", "", "project");
if ($con->connect_error) die("Connection failed: " . $con->connect_error);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Select Lease</title>
<style>
body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #89f7fe, #66a6ff);
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}
.container {
  background: #fff;
  padding: 40px;
  border-radius: 15px;
  width: 450px;
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
  background: #007bff;
  color: #fff;
  border: none;
  cursor: pointer;
  transition: 0.3s;
}
button:hover {
  background: #0056b3;
}
</style>
</head>
<body>
<div class="container">
  <h2>Select Property & Unit</h2>

  <form id="leaseForm">
    <!-- Property Dropdown -->
    <label><b>Select Property:</b></label>
    <select name="property_id" id="propertyDropdown" required onchange="loadUnits(this.value)">
      <option value="">-- Choose Property --</option>
      <?php
      $propertyQuery = mysqli_query($con, "SELECT id, Property_Name FROM property");
      if ($propertyQuery && mysqli_num_rows($propertyQuery) > 0) {
          while ($p = mysqli_fetch_assoc($propertyQuery)) {
              echo '<option value="' . htmlspecialchars($p['id']) . '">' . htmlspecialchars($p['Property_Name']) . '</option>';
          }
      } else {
          echo '<option value="">No properties found</option>';
      }
      ?>
    </select>

    <!-- Unit Dropdown -->
    <label><b>Select Unit:</b></label>
    <select name="unit_id" id="unitDropdown" required disabled>
      <option value="">-- Choose Unit --</option>
    </select>

    <button type="button" onclick="openAgreementPage()">Next</button>
  </form>
</div>

<script>
function loadUnits(propertyID) {
  if (!propertyID) return;

  fetch("getUnits.php?property_id=" + propertyID)
    .then(res => res.json())
    .then(data => {
      let unitDropdown = document.getElementById('unitDropdown');
      unitDropdown.innerHTML = '<option value="">-- Choose Unit --</option>';

      if (data.length === 0) {
        unitDropdown.innerHTML = '<option value="">No units found for this property</option>';
        unitDropdown.disabled = true;
        return;
      }

      data.forEach(u => {
        unitDropdown.innerHTML += `<option value="${u.id}">${u.unit_name}</option>`;
      });

      unitDropdown.disabled = false;
    })
    .catch(err => {
      console.error(err);
      alert("Error loading units.");
    });
}

function openAgreementPage() {
  let propertyID = document.getElementById('propertyDropdown').value;
  let unitID = document.getElementById('unitDropdown').value;

  if (!propertyID || !unitID) {
    alert("Please select both Property and Unit!");
    return;
  }

  window.location.href = "Terminate1.php?property_id=" + propertyID + "&unit_id=" + unitID;
}
</script>
</body>
</html>
