<?php 
$conn = new mysqli("localhost", "root", "", "medicine_inventory");
if($_SERVER['REQUEST_METHOD'] == "POST"){
  $supId = $_POST['supId'] ?? '';
  $company = $_POST['company'] ?? '';
  $address = $_POST['address'] ?? '';
  $contact = $_POST['cont'] ?? '';
  $email = $_POST['email'] ?? '';
  $action = $_POST['action'] ?? '';
  $namer = $_POST['namer'] ?? '';
  $response = 0;
  $sqli= "SELECT * FROM `supplier` WHERE `sup_Company`='$company'";
  $result= $conn->query($sqli);
  function validateEmail($email) {
    // Use filter_var for email validation
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
  }

if($action =='insert'){
 


   if (validateEmail($email)) {
    if ($result->num_rows > 0) {
      echo "Company name already exist";
  
   }
  else{
 
    $sql = "INSERT INTO `supplier`( `sup_Company`, `sup_Address`, `sup_Contact_no.`, `sup_email`) VALUES ('$company','$address','$contact','$email')";
    if(mysqli_query($conn, $sql)){
     echo "Supplier Added Successfully.";
    }else{
 
        echo "some error", $conn->error;
      }
    }
   }else{
     echo "Ivalid Email";
   }
 
  }else if($action == 'update'){

    if($company !== $namer){
      if ($result->num_rows > 0) {
        $response = 1;
        echo "Supplier name Already exist";
      }
    }  

    if($response >= 0){

      if (validateEmail($email)) {

 if($supId == ''){
        $showAlert = true;
     }
    
     else{
        $sql = "UPDATE `supplier` SET `sup_Company`='$company',`sup_Address`='$address',`sup_Contact_no.`='$contact',`sup_email`='$email' WHERE `sup_Id`='$supId'";
      
        if(mysqli_query($conn, $sql)){

          echo "Medicine updated Successfully.";
          
        }else{

            echo "some error", $conn->error;
          }
  
   }  
    }else{
      echo "Ivalid Email";
  }
  }

}else if($action == 'archive'){
  $stmt = $conn->prepare("UPDATE supplier SET archive=1 WHERE sup_Id = $supId");
  $stmt->execute();
  echo 'Archive Success';
}else if($action == 'restore'){
  $stmt = $conn->prepare("UPDATE supplier SET archive=0 WHERE sup_Id = $supId");
  $stmt->execute();
  echo 'Restore Success';
}else if($action == 'delete'){
    
    
    if($supId == ''){
      echo "Select a Supplier first First";
    }else{
      try {
      $sql = "DELETE FROM `supplier` WHERE `sup_Id`= '$supId'";
  
    
      if(mysqli_query($conn, $sql)){
   
       echo "Supplier deleted Successfully.";
   
       
      }else{
   
          echo "some error", $conn->error;
        }
     
      } catch (mysqli_sql_exception $e) {
        // Handle exception caused by foreign key constraint violation
        echo "Failed to delete medicine: Foreign key constraint violation.";
    }
    }
  }
}
?>