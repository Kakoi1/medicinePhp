<?php
session_start();
    $conn = mysqli_connect("localhost", "root", "");
    $db = mysqli_select_db($conn, "medicine_inventory");

    $medId = $_POST['medId'];
    $medname = $_POST['medName'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $status = $_POST['status'];
    $expD =$_POST['expD'];
    $quanBuy = $_POST['quanBuy'];
    $tPrice = $_POST['tPrice'];
    $cash = $_POST['cash'];

    // include 'login_code.php';
    
    $userID = $_SESSION['user_id'];

 

    if(isset($_POST['Buyin'])){
        
        $sql = "INSERT INTO `transactions` (`Med_Id`, `trans_quan`, `trans_total`, `Acc_Id`, `trans_date`) VALUES ( '$medId', '$quanBuy', '$tPrice', '$userID', CURDATE())";

        
    if(mysqli_query($conn, $sql)){
      $ttlProd = $quantity - $quanBuy;

      if($ttlProd <= 0){
        $sqli = "UPDATE `med_inventory` SET `Med_Quantity`='$ttlProd',`Med_status`='Out of Stock' WHERE `Med_Id`='$medId'";
        if(mysqli_query($conn, $sqli)){
  
      echo "<script>alert('Medicine Added Successfully.');</script>";
       header("Location: dashboard.php");
       exit();
        }
      }else{

      $sqli = "UPDATE `med_inventory` SET `Med_Quantity`='$ttlProd',`Med_status`='$status' WHERE `Med_Id`='$medId'";
      if(mysqli_query($conn, $sqli)){

    echo "<script>alert('Medicine Added Successfully.');</script>";
     header("Location: dashboard.php");
     exit();
      }
    }
   }else{
        
       echo "some error", $conn->error;
     }
    }
?>
<?php 
$conn = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($conn, "medicine_inventory");

$del_Id = $_POST['inputSearch'];

  if($del_Id == ''){
    $showAlert = true;
  }else{

  if(isset($_POST['delete'])){
 
    $sql = "DELETE FROM `transactions` WHERE `trans_id`= '$del_Id'";

  
    if(mysqli_query($conn, $sql)){
 
     
      header("Location: dashboard.php");
      echo "<script>alert('Medicine updated Successfully.');</script>";
     
    }else{
 
        echo "some error", $conn->error;
      }
   
     
  }
}
?>
<?php 
 if (isset($showAlert) && $showAlert) {
    echo "<script>alert('Select a Transaction first First to Delete'); window.history.back();</script>";

}
?>