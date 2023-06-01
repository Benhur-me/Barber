<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $username = $_POST["username"];
   $password = $_POST["password"];

   // Establish a connection to the MySQL database
   $servername = "localhost";
   $dbUsername = "root";
   $dbPassword = "";
   $dbName = "barber";

   $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   }

   // Retrieve user credentials from the "users" table
   $sql = "SELECT * FROM users WHERE username='$username'";
   $result = $conn->query($sql);

   if ($result->num_rows == 1) {
       $row = $result->fetch_assoc();
       $storedPassword = $row["password"];

       // Verify the password
       if (password_verify($password, $storedPassword)) {
           $_SESSION["username"] = $username;
           header("Location: index.html");
           exit();
       } else {
           $error = "Invalid username or password";
       }
   } else {
       $error = "Invalid username or password";
   }

   $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <title>Barber Website</title>
   <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <!-- Custom Css -->
        <link rel="stylesheet" href="style.css">

        <!-- Font Families -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inconsolata">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
            integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
   <!-- Include necessary CSS and other dependencies -->
</head>

<body class="w3-sand">

<div class="w3-top">
        <div class="w3-row w3-padding w3-light-gray">
            <div class="w3-col s2">
                <a href="#" class="w3-button w3-block">
                    <i class="fas fa-cut"></i>
                </a>
            </div>
            <div class="w3-col s2">
                <a href="index.html" class="w3-button w3-b w3-block">Home</a>
            </div>
            <div class="w3-col s2">
                <a href="index.html" class="w3-button w3-b w3-block">Opening hours</a>
            </div>
            <div class="w3-col s2">
                <a href="index.html" class="w3-button w3-b w3-block">Prices</a>
            </div>
            <div class="w3-col s2">
                <a href="login.php" class="w3-button w3-b w3-block">Login/Register</a>
            </div>
        </div>
    </div>
   <!-- Login form HTML -->
   <div style="margin-top: 60px;" class="login-box">
       <h1>Login</h1>
       <?php if (isset($error)) { ?>
           <p style="color: red;"><?php echo $error; ?></p>
       <?php } ?>
       <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
           <label for="username">Username:</label>
           <input type="text" id="username" name="username" required>
           <label for="password">Password:</label>
           <input type="password" id="password" name="password" required>
           <input style="background-color:#0077cc;" type="submit" value="Submit"><br>
           <a href="signup.php">Don't have an account. Signup</a>
       </form>
   </div>
</body>
</html>
