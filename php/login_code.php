<?php
$conn = mysqli_connect("localhost", "root", "");
  $db = mysqli_select_db($conn, "medicine_inventory");

  $uname = $_POST["uname"];
  $pass = $_POST["pass"]; 
  $salt = "codeflix";
  $hashedPassword = sha1($pass.$salt);
  $accId = $id;
    if(isset($_POST['login'])){

      

        $sql = "SELECT * FROM accounts WHERE Acc_username = '$uname' AND Acc_password = '$hashedPassword'";
         $result= $conn->query($sql);

         if ($result->num_rows > 0) {
            // User found
            echo "Login successful!";
            
            // Add code to redirect or perform further actions after successful login
            while ($row = $result->fetch_assoc()) {
                $id = $row['Acc_Id'];
                $username = $row['Acc_username'];               
            }
            
            
            // echo "<script>var data = $id;</script>";
            // echo "<script>console.log(data); </script>";
            // echo '<script src="..//script/signup.js"></script>';
            // echo "<script>gago(data);</script>";


            $sqli = "UPDATE `accounts` SET `Acc_date`= CURDATE(),`Acc_time`= CURTIME() WHERE `Acc_username` = '$uname'";
            $conn->query($sqli);

            session_start();
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $username;
            setcookie('user', $username, time() + 24*3600, '/');

            header('Location: dashboard.php');

        } else {

            // $alertMessage = "Incorrect username or password. Please try again.";
            $showAlert = true;

        }


    }
?>

 

<?php
    // Display JavaScript alert if the flag is set
    if (isset($showAlert) && $showAlert) {
        echo "<script>alert('Incorrect username or password. Please try again.'); window.history.back();</script>";
  
    }
    // if ($loggedIn) {
    //     // Embed a script to perform client-side redirection
    //     echo '<meta http-equiv="refresh" content="0;url=dashboard.php">';
    // }
  ?>

