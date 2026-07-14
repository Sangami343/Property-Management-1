<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Registration</title>
<style>
body {
font-family: Arial, sans-serif;
background-color: #f4f4f4;
margin: 0;
padding: 0;
display: flex;
justify-content: center;
align-items: center;
height: 150vh;
}
.container {
background-color: #fff;
padding: 20px;
border-radius: 5px;
box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
width: 350px;
}
h1 {
text-align: center;
color: #333;
}
label {
display: block;
margin-bottom: 8px;
color: #555;
}
input[type="text"],
input[type="email"],
input[type="password"],
input[type="tel"],
input[type="text"] {
width: 100;
padding: 10px;
margin-bottom: 10px;
border: 1px solid #ccc;
border-radius: 4px;
}
button {
width: 100;
padding: 10px;
background-color: #28a745;
border: none;
border-radius: 4px;
color: #fff;
font-size: 16px;
cursor: pointer;
}
button:hover {
background-color: #218838;
}
.error {
color: red;
margin-bottom: 10px;
}
</style>
</head>
<body>
<div class="container">
<h1>User Registration</h1>
<form id="registrationForm">
<label for="username">Username:</label>
<input type="text" id="username" name="username" required>

<label for="email">Email:</label>
<input type="email" id="email" name="email" required>

<label for="password">Password:</label>
<input type="password" id="password" name="password" required>

<label for="confirmpassword">Confirm Password:</label>
<input type="password" id="confirmpassword" name="confirm_password" required>

<label for="firstname">First Name:</label>
<input type="text" id="firstname" name="first_name" required>

<label for="lastname">Last Name:</label>
<input type="text" id="lastname" name="last_name" required>

<label for="phone">Phone Number:</label>
<input type="tel" id="phone" name="phone" required>

<label for="address">Address:</label>
<input type="text" id="address" name="address" required><br>

<button type="submit" onclick="login()">Register</button>
<button type="button" onclick="window.location.href='login.php'">BACK</button>

</form>
<div id="demo"></div>
</div>
<script>
function login() {
    // Get values from form fields
    var username = document.getElementById("username").value.trim();
    var email = document.getElementById("email").value.trim();
    var password = document.getElementById("password").value;
    var confirmpassword = document.getElementById("confirmpassword").value;
    var firstname = document.getElementById("firstname").value.trim();
    var lastname = document.getElementById("lastname").value.trim();
    var phone = document.getElementById("phone").value.trim();
    var address = document.getElementById("address").value.trim();

    // Validate all fields are filled
    if (!username) {
        alert("Username is required.");
        return;
    }

    if (username.length < 4) {
        alert("Username must be at least 4 characters long.");
        return;
    }

    if (!firstname) {
        alert("First name is required.");
        return;
    }

    if (!lastname) {
        alert("Last name is required.");
        return;
    }

    if (!email) {
        alert("Email is required.");
        return;
    }

    var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i;
    if (!emailPattern.test(email)) {
        alert("Invalid email format.");
        return;
    }

    if (!password) {
        alert("Password is required.");
        return;
    }

    if (password.length < 6) {
        alert("Password must be at least 6 characters long.");
        return;
    }

    if (!confirmpassword) {
        alert("Please confirm your password.");
        return;
    }

    if (password !== confirmpassword) {
        alert("Passwords do not match.");
        return;
    }

    if (!phone) {
        alert("Phone number is required.");
        return;
    }

    var phonePattern = /^[0-9]{10}$/;
    if (!phonePattern.test(phone)) {
        alert("Phone number must be 10 digits.");
        return;
    }

    if (!address) {
        alert("Address is required.");
        return;
    }

    // All validations passed, proceed with AJAX submission
    var xhr = new XMLHttpRequest();
    var val = "username=" + (username) +
              "&email=" + (email) +
              "&password=" + (password) +
              "&confirmpassword=" + (confirmpassword) +
              "&firstname=" + (firstname) +
              "&lastname=" + (lastname) +
              "&phone=" + (phone) +
              "&address=" + (address);

    xhr.open("POST", "register1.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
        document.getElementById("demo").innerHTML = xhr.responseText;
        // alert(xhr.responseText);
        window.location.href = 'login.php'; // 🔁 Redirects to login page
    }
};

    xhr.send(val);
}
</script>

</body>
</html>
// hello i am sangami
// i am a dancer
// hey what are you doing now