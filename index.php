<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Registration Form</title>
    <link rel="stylesheet" href="assets/style.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
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
<div class="left-section"><img src="assets/background.png" width="700" height="500"/></div>

<!-- Right section with login form -->
<div class="right-section">
    <div class="container">
        <div class="title">Registration</div>
        <div class="content">
        <form action="register.php" method="POST">
            <div class="user-details">
            <div class="input-box">
                <span class="details">Username</span>
                <input type="text" name="user_name" placeholder="Enter username" required>
            </div>            
            <div class="input-box">
                <span class="details">Email</span>
                <input type="email" name="email" placeholder="Enter email" required>
            </div>
            <div class="input-box">
                <span class="details">Password</span>
                <div class="password-input">
                  <input type="password" name="password" placeholder="Enter password" id="password" required>
                  <i class="far fa-eye" id="togglePassword"></i>
                </div>
              </div>
              <div class="input-box">
                <span class="details">Confirm Password</span>
                <div class="password-input">
                  <input type="password" placeholder="Confirm password" id="confirmPassword" required>
                  <i class="far fa-eye" id="toggleConfirmPassword"></i>
                </div>
              </div>                           
            </div>

            <div class="button">
                <input type="submit" value="Register">
            </div>

            <div style="text-align: center;">
                <p style="display: inline;">Already Have An Account?</p>
                <a href="login.php" style="display: inline;">Login here</a>
            </div>

        </form>
        </div>
    </div>
</div>
    <div class="pic">
     <div>  <img src="http://www.pngmart.com/files/1/Fall-Autumn-Leaves-Transparent-PNG.png" height="75px" width="75px"></img></div>
      <div><img src="http://www.pngmart.com/files/1/Autumn-Fall-Leaves-Pictures-Collage-PNG.png" height="75px" width="75px"></img></div>
      <div>  <img src="http://www.pngmart.com/files/1/Autumn-Fall-Leaves-Clip-Art-PNG.png" height="75px" width="75px" ></img></div>
      <div><img  src="http://www.pngmart.com/files/1/Green-Leaves-PNG-File.png" height="75px" width="75px"></img></div>
       <div> <img src="http://www.pngmart.com/files/1/Transparent-Autumn-Leaves-Falling-PNG.png" height="75px" width="75px"></img></div>
     <div>   <img src="http://www.pngmart.com/files/1/Realistic-Autumn-Fall-Leaves-PNG.png" height="75px" width="75px"></div>
     <!-- <div><img src="http://cdn.clipart-db.ru/rastr/autumn_leaves_025.png" height="75px" width="75px"></div> -->
            
     </div>
     
     <div class="pic pic1">
     <div>  <img src="http://www.pngmart.com/files/1/Fall-Autumn-Leaves-Transparent-PNG.png" height="75px" width="75px"></img></div>
      <div><img src="http://www.pngmart.com/files/1/Autumn-Fall-Leaves-Pictures-Collage-PNG.png" height="75px" width="75px"></img></div>
      <div>  <img src="http://www.pngmart.com/files/1/Autumn-Fall-Leaves-Clip-Art-PNG.png" height="75px" width="75px" ></img></div>
      <div><img  src="http://www.pngmart.com/files/1/Green-Leaves-PNG-File.png" height="75px" width="75px"></img></div>
       <div> <img src="http://www.pngmart.com/files/1/Transparent-Autumn-Leaves-Falling-PNG.png" height="75px" width="75px"></img></div>
     <div>   <img src="http://www.pngmart.com/files/1/Realistic-Autumn-Fall-Leaves-PNG.png" height="75px" width="75px"></div>
     <!-- <div><img src="http://cdn.clipart-db.ru/rastr/autumn_leaves_025.png" height="75px" width="75px"></div> -->
            
     </div>
     
     <div class="pic pic2">
     <div>  <img src="http://www.pngmart.com/files/1/Fall-Autumn-Leaves-Transparent-PNG.png" height="75px" width="75px"></img></div>
      <div><img src="http://www.pngmart.com/files/1/Autumn-Fall-Leaves-Pictures-Collage-PNG.png" height="75px" width="75px"></img></div>
      <div>  <img src="http://www.pngmart.com/files/1/Autumn-Fall-Leaves-Clip-Art-PNG.png" height="75px" width="75px" ></img></div>
      <div><img  src="http://www.pngmart.com/files/1/Green-Leaves-PNG-File.png" height="75px" width="75px"></img></div>

       <div> <img src="http://www.pngmart.com/files/1/Transparent-Autumn-Leaves-Falling-PNG.png" height="75px" width="75px"></img></div>
     <div>   <img src="http://www.pngmart.com/files/1/Realistic-Autumn-Fall-Leaves-PNG.png" height="75px" width="75px"></div>
     <!-- <div><img src="http://cdn.clipart-db.ru/rastr/autumn_leaves_025.png" height="75px" width="75px"></div> -->
            
</div>
    <script>

// --------------------------------------------Toggle Password----------------------------------------------------------

        document.getElementById('togglePassword').addEventListener('click', function() {
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
      
        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
          var confirmPasswordInput = document.getElementById('confirmPassword');
      
          if (confirmPasswordInput.type === 'password') {
            confirmPasswordInput.type = 'text';
            this.classList.remove('far', 'fa-eye');
            this.classList.add('fas', 'fa-eye-slash');
          } else {
            confirmPasswordInput.type = 'password';
            this.classList.remove('fas', 'fa-eye-slash');
            this.classList.add('far', 'fa-eye');
          }
        });


  // --------------------------------------------Password Validation----------------------------------------------------------

      function validateForm() {
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('confirmPassword').value;

        var uppercaseRegex = /[A-Z]/;
        var lowercaseRegex = /[a-z]/;
        var numeralRegex = /[0-9]/;
        var specialCharRegex = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;

        if (
            password !== confirmPassword ||
            !uppercaseRegex.test(password) ||
            !lowercaseRegex.test(password) ||
            !numeralRegex.test(password) ||
            !specialCharRegex.test(password) ||
            password.length < 8
        ) {
            // Passwords don't match or don't meet all requirements
            if (password !== confirmPassword) {
                alert("Password and confirm password do not match.");
            } else {
                alert("Password must contain at least one uppercase letter, one lowercase letter, one numeral, one special character, and be at least 8 characters long.");
            }
            return false;
        } else {
            // Passwords match and meet all requirements
            return true;
        }
      }

      document.querySelector('form').addEventListener('submit', function(e) {
          if (!validateForm()) {
              e.preventDefault(); // Prevent form submission if validation fails
          }
      });

      document.querySelector('form').addEventListener('submit', function(e) {
        if (!validatePassword()) {
          e.preventDefault(); // Prevent form submission if passwords don't match
        }
      });    

      </script>      
            
</body>
</html>