<?php
require 'config.php';

// Function to generate a random salt
function generateSalt($length = 16) {
    return bin2hex(random_bytes($length));
}

// Function to hash the password with a salt
function hashPassword($password, $salt) {
    return hash('sha256', $password . $salt);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = filter_input(INPUT_POST, 'user_name', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

    // Get the JAWSDB_URL from Heroku environment variable
    $db_url = parse_url(getenv('JAWSDB_URL'));

    // Extract the database connection details
    $servername = $db_url['host']; // Database host
    $username = $db_url['user'];   // Database username
    $dbpassword = $db_url['pass'];   // Database password
    $dbname = ltrim($db_url['path'], '/'); // Database name (remove the leading "/")

    // Create connection
    $conn = new mysqli($servername, $username, $dbpassword, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute query to fetch user details
        $stmt = $conn->prepare("SELECT user_name, password_hash, salt FROM users WHERE user_name = ?");
        $stmt->bind_param("s", $user_name);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Username exists, fetch user details
            $stmt->bind_result($email, $password_hash, $salt);
            $stmt->fetch();
            
            // Verify the password
            if (hashPassword($password, $salt) === $password_hash) {
                // Successful login, redirect to form.php
                session_start();
                $_SESSION['user_name'] = $user_name;
                header("Location: form.php");
                exit();
            } else {
                // Invalid password
                echo "<script>alert('Invalid username or password'); window.location.href='login.php';</script>";
            }
        } else {
            // Username does not exist
            echo "<script>alert('Invalid username or password'); window.location.href='login.php';</script>";
        }
        $stmt->close();
        $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css?family=Courgette|Open+Sans&display=swap" rel="stylesheet"> 
    <!-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->
    <style>   
        .left-section {
            z-index: 1;
        }

        /* Left section with background image */
        .left-section img {
            margin-left: 50px;
            margin-right: 50px;
            border-radius: 20px 0 0 20px; /* Rounded corners on the left */
            border: 2px solid #ccc; /* Light border for contrast */
        }

        /* Right section with login card */
        .right-section {
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin-right: 50px;
        } 
        section{
            z-index: 0;
            height:100%;
            width:100%;
            position:absolute ;  background:radial-gradient(#333,#000);
        }
        .pic{
            position:absolute ;
            width:100%;
            height:100%;
            top:0;
            left:0;
        }
        .pic div{
        position:absolute ;
        display:block ;
        }
        .pic div:nth-child(1){
            left:20%; 
            animation:fall 15s linear infinite ;
            animation-delay:-2s;

        }
        .pic div:nth-child(2){
            left:70%; 
            animation:fall 15s linear infinite ;
            animation-delay:-4s;
        }
        .pic div:nth-child(3){
            left:10%; 
            animation:fall 20s linear infinite ;
            animation-delay:-7s;
            
        }
        .pic div:nth-child(4){
            left:50%; 
        animation:fall 18s linear infinite ; 
        animation-delay:-5s;
        }
        .pic div:nth-child(5){
            left:85%; 
            animation:fall 14s linear infinite ;
            animation-delay:-5s;
        }
        .pic div:nth-child(6){
            left:15%; 
            animation:fall 16s linear infinite ;
            animation-delay:-10s;
        }
        .pic div:nth-child(7){
            left:90%; 
            animation:fall 15s linear infinite ;
            animation-delay:-4s;
        }

        @keyframes fall{
            0%{
                opacity:1;
                top:-10%;
                transform:translateX (20px) rotate(0deg);
            }
            20%{
                opacity:0.8;
                transform:translateX (-20px) rotate(45deg);
            }
            40%{

                transform:translateX (-20px) rotate(90deg);
            }
            60%{
                
            transform:translateX (-20px) rotate(135deg); 
            }
            80%{
            
                transform:translateX (-20px) rotate(180deg);
            }
            100%{
                
                top:110%;
                transform:translateX (-20px) rotate(225deg);
            }
            }
        .pic1{
            transform: rotateX(180deg);
        }    
    </style>
</head>
<body>
<!-- Left section with background -->
<div class="left-section"><img src="/background.png" width="700" height="500"/></div>

<!-- Right section with login form -->
<div class="right-section">

    <div class="container">
        <div class="title">Login</div>
        <div class="content">
            <form action="" method="POST"> 
            <div class="user-details">
                <div class="input-box">
                    <span class="details">Username</span>
                    <input type="text" name="user_name" placeholder="Enter username" required>
                </div>
                <div class="input-box">
                    <span class="details">Password</span>
                    <div class="password-input">
                        <input type="password" name="password" placeholder="Enter password" id="password" required>
                        <i class="far fa-eye" id="togglePassword"></i>
                    </div>
                </div>
            </div>
            <div class="button">
                <input type="submit" value="Login">
            </div>
            <div style="text-align: center;">
                <p style="display: inline;">Don't Have An Account?</p>
                <a href="index.php" style="display: inline;">Register here</a>
            </div>
        </form>
        </div>
    </div>
</div>

<div class="pic">
    <div><img src="http://www.pngmart.com/files/1/Fall-Autumn-Leaves-Transparent-PNG.png" height="75px" width="75px"></img></div>
    <div><img src="http://www.pngmart.com/files/1/Autumn-Fall-Leaves-Pictures-Collage-PNG.png" height="75px" width="75px"></img></div>
    <div><img src="http://www.pngmart.com/files/1/Autumn-Fall-Leaves-Clip-Art-PNG.png" height="75px" width="75px" ></img></div>
    <div><img  src="http://www.pngmart.com/files/1/Green-Leaves-PNG-File.png" height="75px" width="75px"></img></div>
    <div><img src="http://www.pngmart.com/files/1/Transparent-Autumn-Leaves-Falling-PNG.png" height="75px" width="75px"></img></div>
    <div><img src="http://www.pngmart.com/files/1/Realistic-Autumn-Fall-Leaves-PNG.png" height="75px" width="75px"></div>
     <!-- <div><img src="http://cdn.clipart-db.ru/rastr/autumn_leaves_025.png" height="75px" width="75px"></div> -->    
</div>
     
<div class="pic pic1">
    <div><img src="http://www.pngmart.com/files/1/Fall-Autumn-Leaves-Transparent-PNG.png" height="75px" width="75px"></img></div>
    <div><img src="http://www.pngmart.com/files/1/Autumn-Fall-Leaves-Pictures-Collage-PNG.png" height="75px" width="75px"></img></div>
    <div><img src="http://www.pngmart.com/files/1/Autumn-Fall-Leaves-Clip-Art-PNG.png" height="75px" width="75px" ></img></div>
    <div><img  src="http://www.pngmart.com/files/1/Green-Leaves-PNG-File.png" height="75px" width="75px"></img></div>
    <div><img src="http://www.pngmart.com/files/1/Transparent-Autumn-Leaves-Falling-PNG.png" height="75px" width="75px"></img></div>
    <div> <img src="http://www.pngmart.com/files/1/Realistic-Autumn-Fall-Leaves-PNG.png" height="75px" width="75px"></div>
     <!-- <div><img src="http://cdn.clipart-db.ru/rastr/autumn_leaves_025.png" height="75px" width="75px"></div> -->      
</div>
     
<div class="pic pic2">
    <div><img src="http://www.pngmart.com/files/1/Fall-Autumn-Leaves-Transparent-PNG.png" height="75px" width="75px"></img></div>
    <div><img src="http://www.pngmart.com/files/1/Autumn-Fall-Leaves-Pictures-Collage-PNG.png" height="75px" width="75px"></img></div>
    <div><img src="http://www.pngmart.com/files/1/Autumn-Fall-Leaves-Clip-Art-PNG.png" height="75px" width="75px" ></img></div>
    <div><img  src="http://www.pngmart.com/files/1/Green-Leaves-PNG-File.png" height="75px" width="75px"></img></div>
    <div><img src="http://www.pngmart.com/files/1/Transparent-Autumn-Leaves-Falling-PNG.png" height="75px" width="75px"></img></div>
    <div><img src="http://www.pngmart.com/files/1/Realistic-Autumn-Fall-Leaves-PNG.png" height="75px" width="75px"></div>
     <!-- <div><img src="http://cdn.clipart-db.ru/rastr/autumn_leaves_025.png" height="75px" width="75px"></div> -->            
</div>

<script>
    // --------------------------------------------Toggle Password----------------------------------------------------------
    document.getElementById('togglePassword').addEventListener('click', function () {
        var passwordInput = document.getElementById('password');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            this.classList.remove('far', 'fa-eye');
            this.classList.add('fas', 'fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            this.classList.remove('fas', 'fa-eye-slash');
            this.classList.add('far', 'fa-eye');
        }
    });
</script>
</body>
</html>
