<?php
include("connection.php");
session_start();

// Registration Logic
if (isset($_POST["register"])) {
    $userid = mysqli_real_escape_string($con, $_POST['UserId']);
    $fullname = mysqli_real_escape_string($con, $_POST['FullName']);
    $emailid = mysqli_real_escape_string($con, $_POST['EmailId']);
    $password = mysqli_real_escape_string($con, $_POST['Password']);
    $confirmPassword = mysqli_real_escape_string($con, $_POST['ConfirmPassword']);


    if ($password != $confirmPassword) {
        $error = "Passwords do not match";
    } else {

        $query = "INSERT INTO user (UserId, FullName, EmailId, Password) VALUES ('$userid', '$fullname', '$emailid', '$password')";

        if (mysqli_query($con, $query)) {
            $success = "Registration successful. Please log in.";
        } else {
            $error = "Error: " . $query . "<br>" . mysqli_error($con);
        }
    }
}
//login logic 

if (isset($_POST['login'])) {
    $uname = $_POST['UserId'];
    $pwd = $_POST['Password'];


    $query = "SELECT * FROM user WHERE UserId='$uname'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);


        $storedPlainTextPassword = $user['Password'];


        if ($pwd === $storedPlainTextPassword) {

            $_SESSION['username'] = $user['UserId'];
            header("Location: dashboard.php");
            exit(); // Add exit() here
        } else {

?>
            <div class="container" style="margin-left: 58px;">
                <div class="alert alert-danger" role="alert" width="300">
                    Incorrect password
                </div>
            </div>
        <?php
        }
    } else {

        ?>
        <div class="container" style="margin-left: 58px;">
            <div class="alert alert-danger" role="alert" width="300">
                User not found
            </div>
        </div>
<?php
    }
}


?>

<?php include("header.php"); ?>

<nav class="navbar">
    <ul>
        <li style="float: left; padding: 5px;">
            <img src="inventorylogo.jpg" alt="Logo" style="height: 50px; width: 50px; border-radius: 50%; margin-right: 10px;">
        </li>
        <li style="float: left; padding: 18px 20px;">
            <h1 style="color: white; margin: 0;">Inventory Management System</h1>
        </li>
        <li><a href="#">Contact Us</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Home</a></li>
    </ul>
</nav>

<div class="hero">
    <div class="form-box">
        <div class="button-box">
            <div id="btn"></div>
            <button type="button" class="toggle-btn" onclick="login()">Log-In</button>
            <button type="button" class="toggle-btn" onclick="register()">Register</button>
        </div>
        <form id="login" class="input-group" method="post" onsubmit="return onSubmit()">
            <!-- Login form -->
            <input type="text" class="input-field" name="UserId" placeholder="User Id" required>
            <input type="password" class="input-field" name="Password" placeholder="Enter Password" required>
            <input type="checkbox" class="check-box"> <span>Remember Password</span>
            <button type="submit" name="login" class="submit-btn">Log-in</button>
        </form>
        <form id="register" class="input-group" method="post">
            <!-- Registration form -->
            <input type="text" class="input-field" name="FullName" placeholder="Enter Full Name" required>
            <input type="text" class="input-field" name="UserId" placeholder="User Id" required>
            <input type="email" class="input-field" name="EmailId" placeholder="Email Id" required>
            <input type="password" class="input-field" name="Password" placeholder="Enter Password" required>
            <input type="password" class="input-field" name="ConfirmPassword" placeholder="Confirm Password" required>
            <input type="checkbox" class="check-box"><span>I agree to the terms and conditions</span>
            <button type="submit" name="register" class="submit-btn">Register</button>
        </form>
    </div>
</div>

<?php include("footer.php"); ?>

<script>
    var x = document.getElementById("login");
    var y = document.getElementById("register");
    var z = document.getElementById("btn");

    function register() {
        x.style.left = "-400px";
        y.style.left = "50px";
        z.style.left = "110px";
    }

    function login() {
        x.style.left = "50px";
        y.style.left = "450px";
        z.style.left = "0";
    }

    function onSubmit() {
        alert("Pressed");
        return true;
    }
</script>
