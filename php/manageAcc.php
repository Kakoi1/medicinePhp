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
   </style>
<body>
<body >
<div class="containers-lg-12"> 
<nav id="sidebar" class="sidebar d-lg-block sidebar sidebar bg-primary">
<p class ="text-white">Manage Accounts</p>
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
      
      <a  id="suplier" href="supplier.php" class="list-group-item list-group-item-action py-2 ripple">
        Suppliers
      </a>
      <a href="stockRequest.php" class="list-group-item list-group-item-action py-2 ripple">
        Manage Request
      </a>
      <a href="recieving.php" class="list-group-item list-group-item-action py-2 ripple">
        Orders
      </a>
    </div>
  </div>
</nav>
<div class="mt-3">*</div>
        <div class="container-fluid mt-5" id="contents">

 
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
    <button class="btn btn-outline-primary me-2" id="arcMed" onclick="fetchArchive(1,'account')">Active Accounts</button>
    <button class="btn btn-primary" id="fetchNone" onclick="window.location.href = 'manageAcc.php'">Refresh</button>
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

    $sql = "SELECT * FROM accounts Where Acc_status = 'pending'";
    $result = $conn->query($sql);
    ?>
    <div id="tableData">
    <table class="table table-striped table-hover">
        <tr class="table-dark text-center">
            <th>Username</th>
            <th>Email</th>
            <th>Status</th>
            <th>Action</th>
           
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr class = 'text-center table-dark' data-user-id = ' ".$row['Acc_Id']."'>";

                echo "<td>" . $row["Acc_username"] . "</td>";
                echo "<td>" . $row["Acc_email"] . "</td>";
                echo "<td>" . $row["Acc_status"] . "</td>";
                echo "<td> <div class ='butoon'><button id = 'approve' class = 'appBut btn btn-primary'>Approve</button>   
                <button id = 'reject' class = 'rejBut btn btn-danger'>Reject</button>
                </div></td>";
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
</div>
<script src="../script/manageSup.js"></script>
<script src="../script/manage.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function(){
    $(document).on('click', '.appBut, .rejBut', function() {
        var userId = $(this).closest('tr').data('user-id');
        var action = $(this).hasClass('appBut') ? 'approve' : 'reject';

        $.ajax({
            type: 'POST',
            url: 'accRespon.php',
            data: { userId: userId, action: action },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    alert('Action performed successfully');
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert('Action failed: ' + data.message);
                }
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