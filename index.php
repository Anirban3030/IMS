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

    // Check if passwords match
    if ($password != $confirmPassword) {
        $error = "Passwords do not match";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into the database
        $query = "INSERT INTO user (UserId, FullName, EmailId, Password) VALUES ('$userid', '$fullname', '$emailid', '$hashed_password')";

        if (mysqli_query($con, $query)) {
            $success = "Registration successful. Please log in.";
        } else {
            $error = "Error: " . $query . "<br>" . mysqli_error($con);
        }
    }
}

// Login Logic
if (isset($_POST["login"])) {
    $userid = mysqli_real_escape_string($con, $_POST['UserId']);
    $password = mysqli_real_escape_string($con, $_POST['Password']);

    // Retrieve user from the database
    $query = "SELECT * FROM user WHERE UserId='$userid'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        // Verify password
        if (password_verify($password, $user['Password'])) {
            // Password is correct, create session and redirect to dashboard
            $_SESSION['user_id'] = $user['UserId'];
            // Redirect to user dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "Invalid username or password";
    }
} 
else{
    // This block executes when the form is not submitted
    // You can remove or modify it as needed
    echo "Error: Login form not submitted";
}
?>
<?php include("header.php"); ?>

<div class="hero">
    <div class="form-box">
        <div class="button-box">
            <div id="btn"></div>
            <button type="button" class="toggle-btn" onclick="login()">Log-In</button>
            <button type="button" class="toggle-btn" onclick="register()">Register</button>
        </div>
        <form id="login" class="input-group" method="post">
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
</script>
