<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Page</title>
<style>
/* ======== BODY STYLING ======== */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background-image: url('image/uploads/back.png');
    background-size: cover;
    background-position: center;
}

/* ======== HEADING ======== */
h1 {
    text-align: center;
    color: #000;
    margin-bottom: 20px;
    letter-spacing: 1px;
}

/* ======== FORM CONTAINER ======== */
form {
    background-color: rgba(255, 255, 255, 0.95);
    padding: 30px 25px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 320px;
    text-align: center;
}

/* ======== LABELS ======== */
label {
    display: block;
    margin: 10px 0 6px;
    color: #333;
    font-weight: bold;
}

/* ======== INPUTS ======== */
input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 18px;
    border: 1px solid #ccc;
    border-radius: 6px;
    box-sizing: border-box;
    font-size: 14px;
}

/* ======== BUTTONS ======== */
button {
    width: 100%;
    padding: 12px;
    background-color: #4CAF50;
    border: none;
    border-radius: 6px;
    color: #fff;
    font-size: 15px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s ease-in-out;
}

button:hover {
    background-color: #45a049;
    transform: scale(1.02);
}

/* ======== ERROR / RESPONSE TEXT ======== */
#demo {
    color: red;
    margin-top: 15px;
    font-weight: bold;
}
</style>
</head>

<body>
    <!--This is login form-->
    <div>
        <h1>LOGIN PAGE</h1>
        <form>
            <label>USERNAME:</label>
            <input type="text" id="username" name="username" required>

            <label>PASSWORD:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" onclick="login()">USER SIGN IN</button><br><br>
            <button type="button" onclick="window.location.href='register.php'">NEW USER SIGN UP</button>
        </form>

        <p id="demo"></p>
    </div>

<script>
function login() {
    event.preventDefault();

    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    // ✅ Get propertyID and unitID from URL if they exist
    const urlParams = new URLSearchParams(window.location.search);
    const propertyID = urlParams.get('propertyID') || '';
    const unitID = urlParams.get('unitID') || '';

    // ✅ Admin login logic with property/unit passing
    if (username === "Admin" && password === "AdminPassword") {
        sessionStorage.setItem("id", "Admin");
        alert("Welcome Admin!");

        // Redirect to dashboard with propertyID and unitID
        window.location.href = "dashborad.php?propertyID=" + encodeURIComponent(propertyID) + "&unitID=" + encodeURIComponent(unitID);
        return;
    }

    // ✅ Normal user login process
    var xhr = new XMLHttpRequest();
    var val = "username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password);

    xhr.open("POST", "login1.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("demo").innerHTML = xhr.responseText;
            alert(xhr.responseText);

            if (xhr.responseText.trim() === "success") {
                // Redirect normal users
                window.location.href = "view1.php";
            } else {
                alert("Invalid username or password");
            }
        }
    };
    xhr.send(val);
}
</script>
</body>
</html>
// HAI i am shashika