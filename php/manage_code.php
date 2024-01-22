<?php 
 $conn = mysqli_connect("localhost", "root", "");
 $db = mysqli_select_db($conn, "medicine_inventory");
 
 $medname = $_POST['medName'];
 $price = $_POST['price'];
 $quantity = $_POST['quantity'];
 $status = $_POST['status'];
 $expD =$_POST['expD'];
 $supId = $_POST['supply'];

 $currentDate = date("Y-m-d");


 $sqli= "SELECT * FROM `med_inventory` WHERE `Med_name`='$medname'";
 $result= $conn->query($sqli);

 if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $expD)) {
// name validation
 if ($result->num_rows > 0) {
    $dupliAlert = true;
 } 
//  date validation
 else if ($expD <= $currentDate) {
  $showDate = true;
  $message1 = 'Invalid Date Inputed';
 }
// quantity validation and price
 else if ($quantity <= 0){
  echo '<script>alert("Invalid Quantity Inputed!")</script>';
 }
 else if ($price <= 0){
  echo '<script>alert("Invalid Price Inputed!")</script>';
 }
 else{

 if(isset($_POST['add'])){
 
   $sql = "INSERT INTO `med_inventory`(`Med_name`, `Med_price`, `Med_Quantity`, `Med_status`, `Med_ExpDate`, `sup_Id`) VALUES ('$medname','$price','$quantity','$status','$expD', '$supId')";
 
   if(mysqli_query($conn, $sql)){

    echo "<script>alert('Medicine Added Successfully.');</script>";
     header("Location: dashboard.php");
     exit();
   }else{

       echo "some error", $conn->error;
     }
  
   }
}  
 }
?>
<?php 
 $conn = mysqli_connect("localhost", "root", "");
 $db = mysqli_select_db($conn, "medicine_inventory");
 
 $medId = $_POST['medId'];
 
 $medname = $_POST['medName'];
 $price = $_POST['price'];
 $quantity = $_POST['quantity'];
 $status = $_POST['status'];
 $expD =$_POST['expD'];
 $supId = $_POST['supply'];


 $sqli= "SELECT * FROM `med_inventory` WHERE `Med_name`='$medname'";
 $result= $conn->query($sqli);

 if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $expD)) {
  // name validation
   if ($result->num_rows > 0) {
      $dupliAlert = true;
   } 
  //  date validation
   else if ($expD <= $currentDate) {
    $dateAlert = true;
    $message = 'Invalid Date Inputed';
}
  // ID validation
 elseif($medId == ''){
    $showAlert = true;
    $message = 'Select An item First';
 }
 else if ($price <= 0){
  echo '<script>alert("Invalid Price Inputed!")</script>';
 }
 else{

 if(isset($_POST['update'])){
 
   $sql = "UPDATE `med_inventory` SET `Med_name` =  '$medname' ,`Med_price`= $price ,`Med_Quantity`= $quantity ,`Med_status`= '$status',`Med_ExpDate`= '$expD',  `sup_Id` = '$supId' WHERE `Med_Id`= '$medId' ";
 
   if(mysqli_query($conn, $sql)){

    echo "<script>alert('Medicine updated Successfully.');</script>";
     header("Location: dashboard.php");

    
   }else{

       echo "some error", $conn->error;
     }
  
   }  
 }
}
?>
<?php 
$conn = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($conn, "medicine_inventory");

  $medId = $_POST['medId'];

  if($medId == ''){
    $showAlert = true;
    $message = 'Select An item First';
  }else{

  if(isset($_POST['delete'])){
 
    $sql = "DELETE FROM `med_inventory` WHERE `Med_Id`='$medId'";

  
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
        echo "<script>alert('medicine name already exist'); window.history.back();</script>";
    }
    else if (isset($showDate) && $showDate) {
      echo "<script>alert('$message1'); window.history.back();</script>";

    }else if (isset($showAlert) && $showAlert) {
      echo "<script>alert('$message'); window.history.back();</script>";

    }

   
?>


