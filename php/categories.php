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
   </style>
<body>
<body >
<div class="containers-lg-12"> 
<nav id="sidebar" class="sidebar d-lg-block sidebar sidebar bg-primary">
<p class ="text-white">Categories</p>
<br>
<div class="imager"></div>
<br>
  <div class="position-sticky">
    <div class="list-group list-group-flush mx-3 mt-4">
   
    <a href="dashboard.php" class="list-group-item list-group-item-action py-2 ripple">
        Dashboard
      </a>
      <a  href="mangeStock.php" class="list-group-item list-group-item-action py-2 ripple">
        Manage Inventory
      </a>
      <a href="transactions.php" class="list-group-item list-group-item-action py-2 ripple">
        Transaction
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
  <button class="btn btn-outline-primary me-3" id="addMed" onclick="openCat()">Add Category</button>
  <button class="btn btn-outline-primary me-3" id="fetchArch" onclick="fetchArchive(1,'category')">Archived Categories</button>
  <button class="btn btn-primary" id="fetchNone" onclick="window.location.href = 'categories.php'">Refresh</button>
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
            <th>Categories</th>

            <th>Action</th>


           
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr class = 'text-start thead-dark ' onclick=\"populateCat(" . $row["id"] . ", '" . $row["name"] ."','".$row["description"]."')\">";

                echo "<td><h4>" . $row["name"] . "</h4>     
                <h5>Description:</h5>

                ".$row["description"]."
                </td>";
                echo "<td> <div class ='butoon'><button id = 'edit' class = ' btn btn-primary editButon' onclick='openSupForm()'>Edit</button>   
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
    <h1 class="text-white"> Category Form</h1>
        <form id="categoryForm">
           


        <div class="input-group mb-4">
            <input type="hidden" class="form-control" name="catId" id="catId" aria-describedby="basic-addon3">
        </div>


        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Category:</span>
            <input type="text" class="form-control" name="namer" id="namer" aria-describedby="basic-addon3" required>
        </div>


        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Description:</span>
            <input type="text" class="form-control" name="desc" id="desc" aria-describedby="basic-addon3" required>
        </div>

       
        <div class="submitBut">


            <input id="add" name="add" class="add btn-primary" type="button" value="add">
           
           <input id="update" name="update" class="update btn-primary" type="button" value="update">
           <input id="archive" name="archive" class="delete btn-primary" type="button" value="archive">
           <input id="cancel" name="cancel" class="cancel btn-outline-primary" type="button" value="cancel" onclick="closeSupForm()">

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
 
 document.getElementById('add').addEventListener('click', function() {
performAction('add');
});

document.getElementById('update').addEventListener('click', function() {
performAction('update');
});

document.getElementById('archive').addEventListener('click', function() {
performAction('archive');
});

function performAction(action) {
// Get form data
const formData = new FormData(document.getElementById('categoryForm'));
formData.append('action', action);

// Perform the AJAX request
fetch('manageCateg.php', {
   method: 'POST',
   body: formData
})
.then(response => response.json())
.then(data => {
   if (data.success) {
       alert('Action performed successfully');
       window.location.href = "categories.php";
   } else {
       alert('Action failed');
   }
})
.catch(error => console.error('Error:', error));
}



$(document).ready(function(){
$(document).on('click', '.butoons-btn', function(event) {
   event.preventDefault(); // Prevent default form submission

   var $form = $(this).closest('form');
        var action = $(this).data('action');
        var formData = $form.serialize(); // Serialize form data

        // Add action to formData if necessary
        formData += '&action=' + action;

        $.ajax({
            type: 'POST',
            url: 'manageCateg.php',
            data: formData, // Send serialized form data
            success: function(response) {
                if (response) {
                    alert('Action performed successfully');
                    window.location.href = "categories.php";
                } else {
                    alert('Action failed');
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