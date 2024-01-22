

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="..//css/mainTable.css"> -->
    <link rel="stylesheet" type="text/css" href="..//css/mainTable.css?v=2"/>

     <!-- User Validation if user is Admin -->
    <?php 
    session_start();
    $admin =  $_SESSION['user_name'];

    if ($admin === 'admin'){
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                // Display the button for admins
                document.getElementById("userHisto").style.display = "block";
                document.getElementById("report").style.display = " inline-block";
                document.getElementById("suplier").style.display = " inline-block";
            });
          </script>';
    }
    ?>

</head>
<body>
<div class="container"> 
        <div class="inner">
<div class="nabar">
<p>Medicine Inventory</p>
    <a href="mangeStock.php">Manage Inventory</a>
    <a style="display: none;" id="report" href="report.php">Sales Report</a>
    <a style="display: none;" id="suplier" href="supplier.php">Suppliers</a>
    <a href="costumerTransac.php">Transaction</a>
    <a id="account" href="login.php">Log Out</a>

    <br>
    
  </div>
 <div class="divi">
    
   

  <form  id="searchForm">
    <div class="searchCon">
  <button type="button" onclick="performSearch()" class="search" id="search" name="search">Search</button>
  <input  class="inputSearch" id="inputSearch" name="inputSearch" type="text" required>
  </div>
  </form>
  <button class="userHisto" id="userHisto" onclick="showHistory()">Logged History</button>
  </div>

<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "medicine_inventory";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM med_inventory";
    $result = $conn->query($sql);
    ?>
    <div id="tableData">
<table>
        <tr>
            <th>Med_id</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Expire Date</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["Med_Id"] . "</td>";
                echo "<td>" . $row["Med_name"] . "</td>";
                echo "<td>" . $row["Med_price"] . "</td>";
                echo "<td>" . $row["Med_Quantity"] . "</td>";
                echo "<td>" . $row["Med_status"] . "</td>";
                echo "<td>" . $row["Med_ExpDate"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No data found</td></tr>";
        }
        ?>
    </table>
    </div>
    </div>
</div>

    <?php 
          $servername = "localhost";
          $username = "root";
          $password = "";
          $dbname = "medicine_inventory";
      
          $conn = new mysqli($servername, $username, $password, $dbname);
      
          if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
          }
      
          $sqli = "SELECT `Acc_Id`, `Acc_fullname`, `Acc_date`, `Acc_time` FROM `accounts`";
          $resulti = $conn->query($sqli);
    ?>

        <div class="overlayHisto" id="overlayHisto">
       
        <div class="userHistory">
        <img src="..//image/icons8-close-50.png" alt="close" height="20px" width="20px" id="closing" onclick="closeHistory()">
        <table>
            <tr>
                <th>Account ID</th>
                <th>Name</th>
                <th>Date Logged In</th>
                <th>Time Logged In</th>
            </tr>
            <?php

        if ($resulti->num_rows > 0) {
            while ($row = $resulti->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["Acc_Id"] . "</td>";
                echo "<td>" . $row["Acc_fullname"] . "</td>";
                echo "<td>" . $row["Acc_date"] . "</td>";
                echo "<td>" . $row["Acc_time"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No data found</td></tr>";
        }
        
        ?>
        </table>

        </div>
        </div>

    <script src="..//script/search.js"></script>  
    <script src="..//script/signup.js"></script>      
 
</body>
</html>