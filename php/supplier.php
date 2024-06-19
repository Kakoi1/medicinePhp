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
<p class ="text-white">Suppliers</p>
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
  <button class="addMed btn-primary" id="addMed" onclick="openSupadd()">Add Supplier</button>
    <button class="btn btn-outline-primary me-2" id="arcMed" onclick="fetchArchive(1,'supplier')">Archived Supplier</button>
    <button class="btn btn-primary" id="fetchNone" onclick="window.location.href = 'supplier.php'">Refresh</button>
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

    $sql = "SELECT * FROM supplier Where archive = 0";
    $result = $conn->query($sql);
    ?>
    <div id="tableData">
    <table class="table table-striped table-hover">
        <tr class="table-dark text-center">
            <th>Supplier Id</th>
            <th>Company</th>
            <th>Address</th>
            <th>Contact No.</th>
            <th>Email</th>
            <th>Action</th>

           
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr class = 'text-center table-dark' onclick=\"populateSup(" . $row["sup_Id"] . ", '" . $row["sup_Company"] . "', '" . $row["sup_Address"] . "', '" . $row["sup_Contact_no."] . "', '" . $row["sup_email"]  . "')\">";

                echo "<td>" . $row["sup_Id"] . "</td>";
                echo "<td>" . $row["sup_Company"] . "</td>";
                echo "<td>" . $row["sup_Address"] . "</td>";
                echo "<td>" . $row["sup_Contact_no."] . "</td>";
                echo "<td>" . $row["sup_email"] . "</td>";
                echo "<td> <div class ='butoon'><button id = 'edit' class = 'editButon' onclick='openSupForm()'>Edit</button>   
                </div></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No data found</td></tr>";
        }
        ?>
    </table>
    </div>
    <div class="overlaySup" id="overlaySup">
        
    <div class="medForm">
    <div class="input-group mb-4 md-12 mt-4">
    </div>
    <h1 class="text-white"> Supplier Form</h1>
        <form id="supForm">
           
        <!-- <label for="supId">Supplier ID:</label>
            <input id="supId" name="supId" class="medId" type="text" readonly> -->

        <div class="input-group mb-4">
            <!-- <span class="input-group-text" id="basic-addon3">Medicine ID</span> -->
            <input type="hidden" class="form-control" name="supId" id="supId" aria-describedby="basic-addon3">
            <input type="hidden" class="form-control" name="namer" id="namer" aria-describedby="basic-addon3">
        </div>

            <!-- <label for="company">Company:</label>
            <input id="company" name="company" class="medName" type="text" required> -->

        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Company:</span>
            <input type="text" class="form-control" name="company" id="company" aria-describedby="basic-addon3" required>
        </div>

            <!-- <label for="address">Address:</label>
            <input id="address" name="address" class="price" type="text" required> -->

        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Address:</span>
            <input type="text" class="form-control" name="address" id="address" aria-describedby="basic-addon3" required>
        </div>

            <!-- <label for="cont">Contact no.:</label>
            <input id="cont" name="cont" class="quantity" type="text" required> -->

        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Contact no.:</span>
            <input type="text" class="form-control" name="cont" id="cont" aria-describedby="basic-addon3" required>
        </div>
           
            <!-- <label for="email">Email:</label>
            <input id="email" name="email" class="quantity" type="text" required>
           <br> -->

        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Email:</span>
            <input type="text" class="form-control" name="email" id="email" aria-describedby="basic-addon3" required>
        </div>
       
        <div class="submitBut">


            <input id="add" name="add" class="btn add btn-primary" onclick="performAction('insert')" type="button" value="add">
           
           <input id="update" name="update" class="btn update btn-primary" onclick="performAction('update')" type="button" value="update">
           <input id="archive" name="archive" class="btn delete btn-primary" onclick="performAction('archive')" type="button" value="Archive">
           <input id="cancel" name="cancel" class="btn cancel btn-primary" type="button" value="cancel" onclick="closeSupForm()">
           <!-- <input id="clear" name="clear" class="btn clear btn-primary" type="button" value="clear"> -->

        </div>
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

     function performAction(action) {
    // Get form data
    const formData = new FormData(document.getElementById('supForm'));
    formData.append('action', action);

    $.ajax({
        type: 'POST',
        url: 'manageSupplier.php', // URL to your login script
        data: formData,
        processData: false, // Prevent jQuery from automatically transforming the data into a query string
        contentType: false, // Set to false to let jQuery automatically set the content type to multipart/form-data
        success: function(response) {
            if (response.trim() === 'Supplier Added Successfully.' || response.trim() === 'Archive Success'|| response.trim() === 'Medicine updated Successfully.') {
                // Redirect to dashboard
                alert(response);
                window.location.href = 'supplier.php';
            } else {
                alert(response);
            }

        },
        error: function(xhr, status, error) {
            // Handle error
            alert('Error: ' + error); // For demonstration, you can replace this with your error handling logic
        }
    });
}
function newAction(action) {

    var $form = $('#thisForm'); // Ensure you're targeting the correct form
    var formData = $form.serialize() + '&action=' + action;

   $.ajax({
       type: 'POST',
       url: 'manageSupplier.php',
       data: formData, // Send serialized form data
       success: function(response) {
if (response.trim() === 'Restore Success'|| response.trim() === 'Supplier deleted Successfully.') {
   alert(response);
   window.location.href = "supplier.php";
   } else {
   alert(response);
   }
       }
   });
}
   </script>
</body>
</html>