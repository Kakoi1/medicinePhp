<?php 
session_start();
 $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "medicine_inventory";
    
    $conn = new mysqli($servername, $username, $password, $dbname);

    $usId =  $_SESSION['user_id'];

    if($usId != false){


    
            $sql = "SELECT * FROM `accounts` WHERE Acc_id = $usId";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {

                $row = $result->fetch_assoc();
                $userN = $row['Acc_username'];
              

            }

    }else{
        echo "<script>alert('no data found');
        document.location.href = 'logout.php';
    </script>";
    }
    include_once 'manageSupplier.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="..//css/mainTable.css?v=2"/>
    <link rel="stylesheet" type="text/css" href="..//css/manage.css?v=2" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    
</head>
<?php 
    if($userN != false){
  
        if ($userN === 'admin'){
            echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("report").style.display = " inline-block";
                document.getElementById("suplier").style.display = " inline-block";
            });
          </script>';
        }
    }
    
    ?>
<style>
      /* Add your CSS styles here */
      .selected-row {
         background-color: #c5e1a5; /* Change this to your desired color */
         font-weight: bold;
      }
      [class*="form-control"]{
        background-color: #2b2a2aaf;
        color: white;
        border: solid 1px;
        border-radius: 8px;
     }   
    
      [class*="form-select"]{
        background-color: #2b2a2aaf;
        color: white;
        border: solid 1px;
        border-radius: 8px;
     } 
     [class*="input-group-text"]{
        font-weight: bold;
        border-radius: 8px;
     }
     .modal {
    display: none; 
    position: fixed; 
    z-index: 1; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgb(0,0,0); 
    background-color: rgba(0,0,0,0.4); 
    padding-top: 60px; 
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto; 
    padding: 20px;
    border: 1px solid #888;
    width: 50%; 
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
.overdue {
    background-color: #f8d7da; /* Light red color */
    color: #721c24; /* Dark red color for text */
}
   </style>
<body>
<body >
<div class="containers-lg-12"> 
<nav id="sidebar" class="sidebar d-lg-block sidebar sidebar bg-primary">
<p class ="text-white">Restock Request</p>
<br>
<div class="imager"></div>
<br>
  <div class="position-sticky">
    <div class="list-group list-group-flush mx-3 mt-4">
   
    <a  id="report" href="adminDash.php" class="list-group-item list-group-item-action py-2 ripple">
        Dashboard
      </a>

    <a href="report.php" class="list-group-item list-group-item-action py-2 ripple">
        Reports
      </a>
      
      <a  id="suplier" href="manageAcc.php" class="list-group-item list-group-item-action py-2 ripple">
        Manage Accounts
      </a>
      <a href="supplier.php" class="list-group-item list-group-item-action py-2 ripple">
        Suppliers
      </a>
      <a href="stockRequest.php" class="list-group-item list-group-item-action py-2 ripple">
        Manage Request
      </a>
    </div>
  </div>
</nav>
<div class="mt-3">*</div>
        <div class="container-fluid mt-5" id="contents">
<!-- <div class="nabar">
<p>Medicine Inventory</p>
    <a href="mangeStock.php">Manage Inventory</a>
    <a style="display: none;" id="report" href="report.php">Sales Report</a>
    <a style="display: none;" id="suplier" href="supplier.php">Suppliers</a>
    <a href="transactions.php">Transaction</a>
    <a id="account" href="logout.php">Log Out</a>

    <br>
    
  </div> -->

  
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top p-2">
    <button onclick="sidebarShow()" type="button" id="sidebarCollapse" class="btn btn-dark">
    <i class="bi bi-arrow-bar-right"></i>
    </button>
    <div class="btn-group">
    <a class="nav-link dropdown-toggle" style="color: white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"><i class="bi bi-person-square"></i><?php echo '   '.$userN?></a>
        <ul class="dropdown-menu dropdown-menu-dark " aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
          </ul>
          </div>
    <div class="medIn">   
    <p class ="text-white">Medicine Inventory</p>
    <div class="logoImg"><img class="logoImg" src="../image/meds.jpg" alt="" width="35px" height="35px"></div>
    </div>

  </nav>
 
  <!-- <form  id="searchForm">
    <div class="searchCon">
  <button type="button" onclick="performSearch()" class="search" id="search" name="search">Search</button>
  <input  class="inputSearch" id="inputSearch" name="inputSearch" type="text" required>
  </div>
  </form> -->
  <div class="supAdd">
  <!-- <button class="btn btn-outline-primary me-3" id="addMed" onclick="openCat()">Add Category</button> -->
  <button class="btn btn-outline-primary me-3" id="fetchArch" onclick="fetchArchive(1,'order')">Order History</button>
  <button class="btn btn-primary" id="fetchNone" onclick="window.location.href = 'recieving.php'">Refresh</button>
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

    ?>
    <div id="tableData">
    <table class="table text-start table-striped table-hover">
    <tr class="table-dark text-center">
        <th>Order ID</th>
        <th>Medicine</th>
        <th>Quantity</th>
        <th>Supplier</th>
        <th>Requester</th>
        <th>Order Date</th>
        <th>Estimated Arrival Date</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    <?php
    $sql = "SELECT o.order_id, mi.Med_name, o.quantity, s.sup_Company, u.Acc_username, o.order_date, o.arrival_date, o.status 
            FROM orders o 
            JOIN med_inventory mi ON o.med_id = mi.Med_Id 
            JOIN supplier s ON o.sup_id = s.sup_Id 
            JOIN accounts u ON o.requester_id = u.Acc_id WHERE o.archive = 0";
    $result = $conn->query($sql);
    $currentDate = date('Y-m-d');

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
           
            $arrivalDate = $row['arrival_date'];
            $arrivalTimestamp = strtotime($arrivalDate);
            $currentTimestamp = strtotime($currentDate);
            $diffDays = ($currentTimestamp - $arrivalTimestamp) / (60 * 60 * 24);
            // echo $diffDays."/";

            if ($diffDays > 30 && $row['status'] == 'Pending') {
                // Mark the order as canceled and archive it
                $updateSql = "UPDATE orders SET status = 'Canceled', archive = 1 WHERE order_id = " . $row['order_id'];
                $conn->query($updateSql);
                continue; // Skip further processing for this order
            }
    
            if ($row['status'] == 'Pending' && $currentDate > $arrivalDate) {
                $row['status'] = 'Overdue';
            }
    
            $rowClass = ($row['status'] == 'Overdue') ? 'overdue' : '';
    
            echo '<tr class="' . $rowClass . ' text-center">';
            echo '<td>' . $row['order_id'] . '</td>';
            echo '<td>' . $row['Med_name'] . '</td>';
            echo '<td>' . $row['quantity'] . '</td>';
            echo '<td>' . $row['sup_Company'] . '</td>';
            echo '<td>' . $row['Acc_username'] . '</td>';
            echo '<td>' . $row['order_date'] . '</td>';
            echo '<td>' . $row['arrival_date'] . '</td>';
            echo '<td>' . $row['status'] . '</td>';
            echo '<td>';
            if ($row['status'] == 'Pending' || $row['status'] == 'Overdue') {
                echo '<button class="btn btn-success complete-order-btn" data-id="' . $row['order_id'] . '">Complete Order</button>';
                echo " ";
                echo '<button class="btn btn-danger cancel-order-btn" data-id="' . $row['order_id'] . '">Cancel</button>';
            }
            echo '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="9">No orders found</td></tr>';
    }
    ?>
</table>
    </div>

    </div>
    </div>
</div>
<script src="../script/manageSup.js"></script>
<script src="../script/manage.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>
$(document).ready(function() {
    $(document).on('click', '.complete-order-btn, .cancel-order-btn', function() {
        var orderId = $(this).data('id');
        var action = $(this).hasClass('complete-order-btn') ? 'complete' : 'cancel';
        $.ajax({
            type: 'POST',
            url: 'completeOrder.php',
            data: { order_id: orderId, action: action },
            success: function(response) {
                alert(response);
                location.reload();
            },
            error: function(xhr, status, error) {
                alert("Error: " + error);
            }
        });
    });
});
   </script>
</body>
</html>