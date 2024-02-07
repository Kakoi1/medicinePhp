

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="..//css/mainTable.css"> -->
    <link rel="stylesheet" type="text/css" href="..//css/mainTable.css?v=2"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

     <!-- User Validation if user is Admin -->
    <?php 
 
    if (isset($_COOKIE['user'])) {
        $admin = $_COOKIE['user'];
    
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
    }
    ?>

</head>
<style>
      /* Add your CSS styles here */
      .selected-row {
         background-color: #c5e1a5; /* Change this to your desired color */
         font-weight: bold;
      }
   </style>
<body>
<div class="container-lg-12 mt-4"> 
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
<table class="table table-striped table-hover">
        <tr class="table-dark text-center">
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
                echo "<tr class = 'text-center'>";
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
        <h2>Logged History</h2>

        <table class="table table-striped table-hover">
        <tr class="table-dark text-center">
                <th>Account ID</th>
                <th>Name</th>
                <th>Date Logged In</th>
                <th>Time Logged In</th>
            </tr>
            <?php

        if ($resulti->num_rows > 0) {
            while ($row = $resulti->fetch_assoc()) {
                echo "<tr class = 'text-center'>";
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
    <script src="..//script/manage.js"></script>     
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>
      document.addEventListener('DOMContentLoaded', function () {
         var rows = document.querySelectorAll('tbody tr');

         rows.forEach(function (row) {
            row.addEventListener('click', function () {
               // Remove the 'selected-row' class from all rows
               rows.forEach(function (r) {
                  r.classList.remove('selected-row');
               });

               // Add the 'selected-row' class to the clicked row
               row.classList.add('selected-row');
            });
         });
      });
   </script>
 
</body>
</html>