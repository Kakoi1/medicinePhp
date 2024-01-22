<?php 
 $conn = mysqli_connect("localhost", "root", "");
 $db = mysqli_select_db($conn, "medicine_inventory");
 
 
 $company = $_POST['company'];
 $address = $_POST['address'];
 $contact = $_POST['cont'];
 $email =$_POST['email'];

 $sqli= "SELECT * FROM `supplier` WHERE `sup_Company`='$company'";
 $result= $conn->query($sqli);

 function validateEmail($email) {
  // Use filter_var for email validation
  return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

 if ($result->num_rows > 0) {
    $dupliAlert = true;
 }
 

else{
 if (validateEmail($email)) {
  
 if(isset($_POST['add'])){
 
   $sql = "INSERT INTO `supplier`( `sup_Company`, `sup_Address`, `sup_Contact_no.`, `sup_email`) VALUES ('$company','$address','$contact','$email')";
 
   if(mysqli_query($conn, $sql)){

    echo "<script>alert('Medicine Added Successfully.');</script>";
     header("Location: dashboard.php");
     exit();
   }else{

       echo "some error", $conn->error;
     }
  
   }
  }else{
    $alertEmail = true;
  }
}  

?>
<?php 
 $conn = mysqli_connect("localhost", "root", "");
 $db = mysqli_select_db($conn, "medicine_inventory");
 
 $supId = $_POST['supId'];
 
 $company = $_POST['company'];
 $address = $_POST['address'];
 $contact = $_POST['cont'];
 $email =$_POST['email'];

 $sqli= "SELECT * FROM `supplier` WHERE `sup_Company`='$company'";
 $result= $conn->query($sqli);

if ($result->num_rows > 0) {
    $dupliAlert = true;

 }
else if($supId == ''){
    $showAlert = true;
 }

 else{

   if (validateEmail($email)) {
    

    if(isset($_POST['update'])){
    
        $sql = "UPDATE `supplier` SET `sup_Company`='$company',`sup_Address`='$address',`sup_Contact_no.`='$contact',`sup_email`='$email' WHERE `sup_Id`='$supId'";
      
        if(mysqli_query($conn, $sql)){

          echo "<script>alert('Medicine updated Successfully.');</script>";
          header("Location: dashboard.php");

          
        }else{

            echo "some error", $conn->error;
          }
  
   }  
    }else{
      $alertEmail = true;
  }
}
?>
<?php 
$conn = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($conn, "medicine_inventory");

$supId = $_POST['supId'];

  if($supId == ''){
    $showAlert = true;
  }else{

  if(isset($_POST['delete'])){
 
    $sql = "DELETE FROM `supplier` WHERE `sup_Id`= '$supId'";

  
    if(mysqli_query($conn, $sql)){
 
     echo "<script>alert('Medicine updated Successfully.');</script>";
      header("Location: dashboard.php");
 
     
    }else{
 
        echo "some error", $conn->error;
      }
   
     
  }
}
?>
<?php
    // Display JavaScript alert if the flag is set
    
    if(($dupliAlert) && $dupliAlert) 
    {
        echo "<script>alert('Company name already exist'); window.history.back();</script>";
    }
    else if (isset($showAlert) && $showAlert) {
        echo "<script>alert('Select a Supplier first First'); window.history.back();</script>";
  
    }else if (isset($alertEmail) && $alertEmail) {
      echo "<script>alert('Ivalid Email'); window.history.back();</script>";

  }
?>
