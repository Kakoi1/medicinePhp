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
    <link rel="stylesheet" type="text/css" href="..//css/mainTable.css?v=1"/>
    <!-- <link rel="stylesheet" href="..//css/manage.css"> -->
    <link rel="stylesheet" type="text/css" href="..//css/manage.css?v=1" />

     <!-- User Validation if user is Admin -->
    <?php 
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
    <a id="manage" href="mangeStock.php">Manage Inventory</a>
    <a style="display: none;" id="report" href="report.php">Sales Report</a>
    <a style="display: none;" id="suplier" href="supplier.php">Suppliers</a>
    <a id="account" href="login.php">Log Out</a>
  </div>
  <div class="divi">
    <form  id="searchForm">
      <div class="searchCon">
    <button type="button" onclick="performSearch()" class="search" id="search" name="search">Search</button>
    <input  class="inputSearch" id="inputSearch" name="inputSearch" type="text" required>
    </div>
    </form>
   
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
            <th>Click</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr onclick=\"populateForm(" . $row["Med_Id"] . ", '" . $row["Med_name"] . "', " . $row["Med_price"] . ", " . $row["Med_Quantity"] . ",'" . $row["Med_status"] . "','" . $row["Med_ExpDate"] . "')\">";
                echo "<td>" . $row["Med_Id"] . "</td>" ;
                echo "<td>" . $row["Med_name"] . "</td>";
                echo "<td>" . $row["Med_price"] . "</td>";
                echo "<td>" . $row["Med_Quantity"] . "</td>";
                echo "<td>" . $row["Med_status"] . "</td>";
                echo "<td>" . $row["Med_ExpDate"] . "</td>";
                echo "<td> <button class='addMed' id='addMed' onclick='openTransac()'>Buy</button></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No data found</td></tr>";
        }
        ?>
    </table>
    </div>
    <div class="medTransac" id="medTransac">
        <div class="transacForm">
        <h1>Add Transaction</h1>
        <form id="MedForm" action="transacCode.php" method="post">
           <div class="right">
        <label for="medId">Medicine ID:</label>
            <input id="medId" name="medId" class="medId" type="text" readonly>

            <label for="cars">Medicine Name:</label>
            <input id="medName" name="medName" class="medName" type="text" required readonly>

            <label for="price">Medicine Price:</label>
            <input id="price" name="price" class="price" type="number" required readonly>

            <label for="quantity">Medicine Quantity:</label>
            <input id="quantity" name="quantity" class="quantity" type="number" required readonly>
            <label for="status">Status:</label><br>
            <input id="status" name="status" class="status" type="text" required readonly>

            <label for="expD">Expire Date:</label>
            <input id="expD" name="expD" class="expD" type="date" required readonly>
            
            </div>
          
           <!-- <select name="status" id="status" class="status" readonly>
                <option value="out of stock">Out of Stock</option>
                <option value="available">Available</option>
           </select><br> -->
          
            <div class="left">
            <label for="quanBuy">Quantity :</label>
            <input id="quanBuy" name="quanBuy" class="quanBuy" type="number" required oninput="calculateTotalPrice()">
        
            <label for="tPrice">Total Price:</label>
            <input id="tPrice" name="tPrice" class="tPrice" type="number" required readonly>

            <label for="cash">Cash:</label>
            <input id="cash" name="cash" class="cash" type="number" required onchange="calculateChange()">

            <label for="change">Change:</label>
            <input id="change" name="change" class="change" type="number" required readonly>
            <br>
            </div>
        <div class="submitBut">

            <input id="Buyin" name="Buyin" class="add" type="submit" value="Buy">
            <input id="cancel" name="cancel" class="cancel" type="submit" value="cancel" onclick="closeTransac()">
            <input id="clear" name="clear" class="clear" type="submit" value="clear">

        </div>
        </form>
        </div>
        </div>
    </div>
</div>
<script src="..//script/manage.js"></script>
<script>
  
    function calculateTotalPrice() {
    var quan = parseFloat(document.getElementById('quanBuy').value);
    var price = parseFloat(document.getElementById('price').value);
    var prodQuan =parseFloat(document.getElementById('quantity').value)  

        // Get quantity and price values
        if(prodQuan <= 0){
        alert("No stock");
        document.getElementById('quanBuy').value ="";
        }else if(prodQuan < quan){
            alert("Insufficient Stock");
            document.getElementById('quanBuy').value = prodQuan;
        }else{

        // Calculate total price
        var totalPrice = quan * price;

        // Update the total price display
        document.getElementById('tPrice').value = totalPrice;  
    }
    }
    function calculateChange(){
        var cashAmount =parseFloat(document.getElementById('cash').value)
        var totalPrice =parseFloat(document.getElementById('tPrice').value)
        if(cashAmount < totalPrice){
            alert("invalid Amount")
        }else{
        var totalChange =cashAmount -totalPrice;
        document.getElementById('change').value = totalChange; 
    }
    }
    Buyin.addEventListener('click', calculateChange);
    
</script> 
<script src="..//script/signup.js"></script>
<script src="..//script/search.js"></script>
</body>
</html>