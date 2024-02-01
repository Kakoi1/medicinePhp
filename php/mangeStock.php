<?php 

$conn = new mysqli("localhost", "root", "", "medicine_inventory");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM med_inventory";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="..//css/mainTable.css?v=1"> -->
    <link rel="stylesheet" type="text/css" href="..//css/mainTable.css?v=2"/>
    <!-- <link rel="stylesheet" href="..//css/manage.css"> -->
    <link rel="stylesheet" type="text/css" href="..//css/manage.css?v=2" />

    <!-- User Validation if user is Admin -->
    <?php 
    // session_start();
    if (isset($_COOKIE['user'])) {
        $admin = $_COOKIE['user'];
    
        if ($admin === 'admin'){
            echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    document.getElementById("report").style.display = " inline-block";
                    document.getElementById("suplier").style.display = " inline-block";
                });
              </script>';
        }
    }
  
   
    ?>

</head>
<body>
    <div class="container"> 
        <div class="inner">

   
<div class="nabar">
    <p>Manage Inventory</p>
    <a class="home" href="dashboard.php">HOME</a>
    <a style="display: none;" id="report" href="report.php">Sales Report</a>
    <a style="display: none;" id="suplier" href="supplier.php">Suppliers</a>
    <a href="costumerTransac.php">Transaction</a>
    <a id="account" href="login.php">Log Out</a>
    
  </div>
  <div class="divi">
    <form  id="searchForm">
      <div class="searchCon">
    <button type="button" onclick="performSearch()" class="search" id="search" name="search">Search</button>
    <input  class="inputSearch" id="inputSearch" name="inputSearch" type="text" required>
    </div>
    </form>
    <button class="addMed" id="addMed" onclick="openMedadd()">Add Medicine</button>
    </div>
 
  
  <div id="tableData">
  <table id="Datatable">
        <tr>
            <th>Med_id</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Expire Date</th>
            <th>Supplier Id</th>
            <th></th>

        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr onclick=\"populateForm(" . $row["Med_Id"] . ", '" . $row["Med_name"] . "', " . $row["Med_price"] . ", " . $row["Med_Quantity"] . ",'" . $row["Med_status"] . "','" . $row["Med_ExpDate"] . "', " . $row["sup_Id"] . ")\">";
                echo "<td>" . $row["Med_Id"] . "</td>" ;
                echo "<td>" . $row["Med_name"] . "</td>";
                echo "<td>" . $row["Med_price"] . "</td>";
                echo "<td>" . $row["Med_Quantity"] . "</td>";
                echo "<td>" . $row["Med_status"] . "</td>";
                echo "<td>" . $row["Med_ExpDate"] . "</td>";
                echo "<td>" . $row["sup_Id"] . "</td>";
                echo "<td> <div class ='butoon'><button id = 'edit' class = 'editButon' onclick='openMedupdate()'>Edit</button>   
                </div></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No data found</td></tr>";
        }
        ?>
    </table>
    </div>
    <div class="overlayMed" id="overlayMed">
        <div class="medForm">
        <img src="..//image/icons8-close-50.png" alt="close" height="20px" width="20px" id="closing" onclick="closeMedupdate()">
            <h1>Medicine Form</h1>
        <form id="MedForm" action="manage_code.php" method="post">

        <label for="medId">Medicine ID:</label>
            <input id="medId" name="medId" class="medId" type="text" readonly >

            <label for="cars">Medicine Name:</label>
            <input id="medName" name="medName" class="medName" type="text" required>

            <label for="price">Medicine Price:</label>
            <input id="price" name="price" class="price" type="number" required>

            <label for="quantity">Medicine Quantity:</label>
            <input id="quantity" name="quantity" class="quantity" type="number" required oninput="statChange()">
            

            <label for="status">Status:</label><br>
           <select name="status" id="status" class="status">             
                <option value="Available">Available</option>
                <option value="Out of Stock">Out of Stock</option>
           </select><br>

           <label for="expD">Expire Date:</label>
            <input id="expD" name="expD" class="expD" type="date" required>

         <label for="">Supplier:</label> 
         <br>  
        <?php

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "medicine_inventory";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT `sup_Id`, `sup_Company` FROM `supplier`";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

        echo "<select name='supply' id = 'supply'>";
    
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['sup_Id'] . "'>". $row['sup_Id'] .' '. $row['sup_Company'] . "</option>";
        }
    

        echo "</select>";
     } else {
        echo "No results found";
        }
    
        $conn->close();
        ?>

        

        <div class="submitBut">

            <input id="add" name="add" class="add" type="submit" value="add">
            <input id="update" name="update" class="update" type="submit" value="update">
            <input id="delete" name="delete" class="delete" type="submit" value="delete">
            <input id="clear" name="clear" class="clear" type="submit" value="clear">
            </form>
        </div>
        </div>
    </div>
    </div>
</div>
<script src="..//script/manage.js"></script>
<script src="..//script/search.js"></script>
<script>
  
  
   function statChange(){
    var quan = parseFloat(document.getElementById('quantity').value)  
   if(quan <= 0){
    document.getElementById('status').value = 'Out of Stock';
   }else{
    document.getElementById('status').value = 'Available';
   }
  
}
document.getElementById("status").addEventListener("mousedown", function(e) {
      e.preventDefault(); // Prevent the default action
    });
</script>  
</body>
</html>
