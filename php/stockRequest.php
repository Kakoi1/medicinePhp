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
      <a href="recieving.php" class="list-group-item list-group-item-action py-2 ripple">
        Orders
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
  <button class="btn btn-outline-primary me-3" id="fetchArch" onclick="fetchArchive(1,'request')">Archived Request</button>
  <button class="btn btn-primary" id="fetchNone" onclick="window.location.href = 'stockRequest.php'">Refresh</button>
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

    $sql = "SELECT * FROM categories where archive = 0";
    $result = $conn->query($sql);
    ?>
    <div id="tableData">
    <table class="table text-start table-striped table-hover">
        <tr class="table-dark text-start">
                <th>Medicine</th>
                <th>Quantity</th>
                <th>Requester</th>
                <th>Comments</th>
                <th>Status</th>
                <th>Actions</th>


           
        </tr>

        <?php

$sql = "SELECT rr.id, mi.Med_name, mi.sup_Id, rr.quantity, u.Acc_username, rr.comments, rr.status 
        FROM restock_requests rr 
        JOIN med_inventory mi ON rr.med_id = mi.Med_Id 
        JOIN accounts u ON rr.requester_id = u.Acc_id WHere rr.archive = 0";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['Med_name'] . '</td>';
        echo '<td>' . $row['quantity'] . '</td>';
        echo '<td>' . $row['Acc_username'] . '</td>';
        echo '<td>' . $row['comments'] . '</td>';
        echo '<td>' . $row['status'] . '</td>';
        echo '<td>';
        if ($row['status'] == 'Pending') {
            echo '<button class="btn btn-success approve-btn" data-id="' . $row['id'] . '">Approve</button>';
            echo "   ";
            echo '<button class="btn btn-danger reject-btn" data-id="' . $row['id'] . '">Reject</button>';
        }
        if ($row['status'] == 'approved') {
            echo '<button class="btn btn-primary create-order-btn" data-id="' . $row['id'] . '" data-supplier-id="' . $row['sup_Id'] . '">Create Order</button>';
        }
        echo '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="6">No restock requests found</td></tr>';
}


?>
    </table>
    </div>
  
    <div id="createOrderModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form id="createOrderForm">
            <input type="hidden" id="requestId" name="requestId">
            <input type="hidden" id="supplierId" name="supplierId">
            <div class="form-group">
                <label for="estimatedArrivalDate">Estimated Arrival Date:</label>
                <input type="date" class="form-control" id="estimatedArrivalDate" name="estimatedArrivalDate" required>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

    </div>
    </div>
</div>
<script src="../script/manageSup.js"></script>
<script src="../script/manage.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>
  $(document).ready(function() {
    // Approve or reject requests
    $(document).on('click', '.approve-btn, .reject-btn', function() {
        var requestId = $(this).data('id');
        var action = $(this).hasClass('approve-btn') ? 'approve' : 'reject';
        $.ajax({
            type: 'POST',
            url: 'manageRestockRequest.php',
            data: { id: requestId, action: action },
            success: function(response) {
                alert(response);
                location.reload();
            },
            error: function(xhr, status, error) {
                alert("Error: " + error);
            }
        });
    });

    // Create purchase order from approved request
    var modal = document.getElementById("createOrderModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Show the modal and pre-fill hidden fields when "Create Order" button is clicked
$(document).on('click', '.create-order-btn', function() {
    var requestId = $(this).data('id');
    var supplierId = $(this).data('supplier-id');

    $('#requestId').val(requestId);
    $('#supplierId').val(supplierId);

    modal.style.display = "block";
});

// Handle form submission
$('#createOrderForm').submit(function(e) {
    e.preventDefault();

    var formData = $(this).serialize();

    $.ajax({
        type: 'POST',
        url: 'createPurchaseOrder.php',
        data: formData,
        success: function(response) {
            alert(response);
            modal.style.display = "none";
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