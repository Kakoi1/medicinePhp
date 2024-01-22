
<?php
  $conn = mysqli_connect("localhost", "root", "");
  $db = mysqli_select_db($conn, "medicine_inventory");
  
  $username = $_POST['username'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $email = $_POST['email'];
  $repass =$_POST['repass'];
  $salt = "codeflix";
  $hashedPassword = sha1($password.$salt);

  function validateEmail($email) {
    // Regular expression for basic email validation
    $emailRegex = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/';

    // Use preg_match to perform the validation
    if (preg_match($emailRegex, $email)) {
        return true; // Valid email
    } else {
        return false; // Invalid email
    }
}

if (validateEmail($email)) {


  if(isset($_POST['submits'])){

    $sqli = "SELECT`Acc_username`, `Acc_fullname` FROM `accounts` WHERE `Acc_username`= '$username'";
    $result= $conn->query($sqli);

  

  if($repass != $password){

    $showAlert = true;

    $message = "Password Doesn't match. Please try again.";

  }
   

  else if ($result->num_rows > 0) {
    $showAlert = true;
    $message = "Username Already Taken";
  }else{

    $sql = "INSERT INTO `accounts`( `Acc_username`, `Acc_fullname`, `Acc_password`, `Acc_email`, `Acc_date`, `Acc_time`) VALUES ('$username','$name','$hashedPassword','$email', CURDATE(), CURTIME())";
 
    if(mysqli_query($conn, $sql)){

     
      header("Location: login.php");
      exit();
    }else{

        echo "some error", $conn->error;
      }
   
    }  
  }
} else {
  echo "<script>alert('Invalid Email'); window.history.back();</script>";
}
?>
 <?php
    // Display JavaScript alert if the flag is set
    if (isset($showAlert) && $showAlert) {
        echo "<script>alert('$message'); window.history.back();</script>";
  
    }
  ?>
