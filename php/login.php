
 <?php if (isset($alertMessage)): ?>
        <script>
            alert('<?php echo $alertMessage; ?>');
        </script>
    <?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="..//css/login.css"> -->
    <link rel="stylesheet" type="text/css" href="..//css/login.css?v=2"/>
    <!-- <link rel="stylesheet" href="..//css/signUp.css"> -->
    <link rel="stylesheet" type="text/css" href="..//css/signUp.css?v=2"/>
</head>
<body>
    <div class="container">
        <div class="inner-cont">
            <div class="cover"> 
            <h1>MIS</h1>
            <h2>Medicine Inventory System</h2>         
            <div class="login">
                <p>Username:</p>
                <form action="login_code.php" method="post">
                <input class="usern" type="text" id="uname" name="uname">
                <p>Password:</p>
                <input class="pass" type="password" id="pass" name="pass">
                <br>
                <br>
                <!-- <div class="buts"> -->
                <button name="login" id="login" class="but">Login</button>
            </form>
                <!-- <br> -->
                <button id="jister" class="rejis">Sign up</button>
            <!-- </div> -->
        
            </div>
      
            <div class="overlay" id="divOne">
                <div class="wrap">
                    <img src="..//image/icons8-close-50.png" alt="close" height="20px" width="20px" id="closing">
                    <h2 style="color: black;">Sign up</h2>
                    <h3>Fill up The form</h3>
                    <form id="rejister" action="..//php/data_base.php" method="post">
                    <div class="form">
                        

                        <input placeholder="Username" type="text" class="username" id="username" name="username" required>
                        <br>
                        <input placeholder="Full Name" type="text" class="name" id="name" name="name" required>
                        <br>
                        <input placeholder="Password" type="password" class="password" id="password" name="password" required>
                        <br>
                        <input placeholder="Retype-Password" type="password" class="repass" id="repass" name="repass" required>
                        <br>
                        <input placeholder="Email" type="text" class="email" id="email" name="email" required>
                        <br>
                        <input type="submit" name="submits" id="submits" class="submits">

                   
                    </div>
                </form>
                </div>
            </div>
        
  
        </div>
       
        </div>
       
    </div>
    <script src="..//script/signup.js"> 

</script>
</body>
</html>