
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login And Registration Form</title>
    <link rel="stylesheet" href="..//css/styles.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
</head>
<body>
    <!-- <header class="header">
        <nav class="navbar">
           <a href="#">Home</a>
           <a href="#">About</a>
           <a href="#">Services</a>
           <a href="#">Contact</a>

        </nav>

        <form action="#" class="search-bar">
         <input type="text" placeholder="Search..."> 
         <button type="submit"><i class='bx bx-search'></i></button>
        </form>
    </header> -->
   <div class="background"></div>
    <div class="container">
      <div class="content">
        <h2 class="logo"><i class='bx bxs-notepad'></i>Medicine Inventory</h2>

        <div class="text-sci">
            <h2>Welcome !<br><span>To Our Medicine Inventory App.</span></h2>

            <p>A digital platform designed for users to create, organize, and store Medicine efficiently.</p>

            <div class="social-icons">
                <a href=""><i class='bx bxl-facebook' ></i></a>
                <a href=""><i class='bx bxl-instagram-alt' ></i></a>
                <a href=""><i class='bx bxl-twitter' ></i></a>
                <a href=""><i class='bx bxl-youtube' ></i></a>
            </div>
        </div>
      </div>

      <div class="logreg-box">
        <div class="form-box login">
            <form action="" id="loginForm" method="post" autocomplete="">
                <h2>Sign In</h2>

                <div class="input-box">
                    <span class="icon"><i class='bx bxs-envelope'></i></span>
                    <input type="username" required name ='users'>
                    <label >Username</label>
                </div>

                <div class="input-box">
                    <span class="icon"><i class='bx bxs-lock'></i></span>
                    <input type="password" required name="passw">
                    <label >Password</label>
                </div>

                <!-- <div class="remember-forgot">
                    <a href="forgotPass.php">Forgot Password?</a>
                </div> -->

                <button type="button" id="loginButton" name="logi" class="btn">Sign In</button>

                <div class="login-register">
                    <p>Don't have an account? <a href="#" class="register-link">Sign up</a></p>
                </div>


            </form>


        </div>
      
        <div class="form-box register">
            <form action="" id="signupForm" method ="post">
                <h2>Sign Up</h2>

                <div class="input-box">
                    <span class="icon"><i class='bx bxs-envelope'></i></span>
                    <input type="text" required name="email">
                    <label >Email</label>
                </div>

                <div class="input-box">
                    <span class="icon"><i class='bx bxs-user-plus'></i></span>
                    <input type="username" required name="usern">
                    <label >Username</label>
                </div>

                <div class="input-box">
                    <span class="icon"><i class='bx bxs-lock'></i></span>
                    <input type="password" required name="pass">
                    <label >Password</label>
                </div>

                <div class="input-box">
                    <span class="icon"><i class='bx bxs-lock'></i></span>
                    <input type="password" required name="repass">
                    <label >Retype Password</label>
                </div>
                

                <!-- <div class="remember-forgot">
                    <label ><input type="checkbox">I agree to terms & conditions </label>
                    
                </div> -->

                <!-- <button type="submit" class="btn" name="signup">Sign Up</button> -->
                <input type="button" class="btn" name="signup" id="signupButton" value = 'SIGN UP'>

                <div class="login-register">
                    <p>Already have an account? <a href="#" class="login-link">Sign In</a></p>
                </div>

            </form>
        </div>
      </div>

    </div>
    
    <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close">&times;</span>
            <p><?php echo $message?></p>
        </div>
    </div>
    
    <script src="..//script/login.js"></script>

    <script>
        var closeButton = document.getElementsByClassName("close")[0];

// When the user clicks the button, show the popup

// When the user clicks on the close button, hide the popup
closeButton.onclick = function() {
    popup.style.display = "none";
    window.history.back();
}
    </script>

<script>
    $(document).ready(function () {
        // When login button is clicked
        $("#loginButton").click(function () {
            // Get form data
            var formData = $("#loginForm").serialize();

            // Send AJAX request
            $.ajax({
                type: "POST",
                url: "login_code.php", // URL to your login script
                data: formData,
                success: function (response) {
                    if (response.trim() === "Login successful!") {
                        // Redirect to dashboard
                        alert(response);
                        window.location.href = "dashboard.php";
                    }else if(response.trim() === "Admin Login successful!"){
                        alert(response);
                        window.location.href = "adminDash.php";
                    } else {
                        // Alert the error message
                        alert(response);
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error
                    alert("Error: " + error); // For demonstration, you can replace this with your error handling logic
                }
            });
        });
    });

</script>
<script>
    
    $(document).ready(function () {
        $("#signupButton").click(function () {
            var formData = $("#signupForm").serialize();
            $.ajax({
                type: "POST",
                url: "data_base.php", // Update with your PHP script URL
                data: formData,
                success: function (response) {
                    if (response.trim() === "User registered successfully.") {
                        // Redirect to dashboard
                        alert(response);
                        window.location.href = "logout.php";
                    } else {
                        // Alert the error message
                        alert(response);
                    }
                },
                error: function (xhr, status, error) {
                    alert("Error: " + error);
                }
            });
        });
    });
</script>
</body>
</html>