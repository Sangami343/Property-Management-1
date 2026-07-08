<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Page</title>
<style>
body {
font-family: Arial, sans-serif;
background-color: #f4f4f4;
margin: 0;
padding: 0;
display: flex;
justify-content: center;
align-items: center;
height: 100vh;
}
h1 {
text-align: center;
color: #333;
}
form {
background-color: #fff;
padding: 20px;
border-radius: 10px;
box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
width: 300px;
text-align: center;
}
label {
display: block;
margin: 10px 0 5px;
color: #333;
}
input[type="text"], input[type="password"] {
width: 100%;
padding: 10px;
margin: 5px 0 20px;
border: 1px solid #ddd;
border-radius: 5px;
}
button {
background-color: #4CAF50;
border: none;
color: white;
padding: 10px 20px;
text-align: center;
text-decoration: none;
display: inline-block;
font-size: 16px;
margin: 10px 2px;
cursor: pointer;
border-radius: 5px;
width: 100%;
}
button:hover {
background-color: #45a049;
}
#demo {
color: red;
margin-top: 20px;
}
</style>
</head>
<body>
<center>
<h1>LOGIN PAGE</h1>
<form onsubmit="return login()">
<label>USERNAME:</label>
<input type="text" id="username" name="username" required><br><br>
<label>PASSWORD:</label>
<input type="password" name="password" required id="password"><br><br>
<button type="submit">LOGIN</button><br><br>
</form>
<p id="demo"></p>
</center>

<script>
function login() {
var username = document.getElementById("username").value;
var password = document.getElementById("password").value;

var xhr = new XMLHttpRequest();
var val = "username=" +username +
         "&password=" +password;
xhr.open("POST", "admin1.php", true);
xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

xhr.onreadystatechange = function() {
if (xhr.readyState == 4 && xhr.status == 200) {
document.getElementById("demo").innerHTML = xhr.responseText;
if (xhr.responseText.trim() === "Welcome Admin!") {
window.location.href = "property.php";
}
}
};
xhr.send(val);
return false; // Prevent form submission
}
</script>
</body>
</html>
