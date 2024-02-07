
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="..//css/mainTable.css?v=2"/>
    <link rel="stylesheet" type="text/css" href="..//css/manage.css?v=2" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
<div class="container-lg-12 mt-4"> 
        <div class="inner">
<div class="nabar">
<p>Medicine Inventory</p>
<a class="home" href="dashboard.php">Home</a>
<a href="mangeStock.php">Manage Inventory</a>
    <a href="report.php">Sales Report</a>
    <a href="costumerTransac.php">Transaction</a>
    <a id="account" href="login.php">Log Out</a>
    <br>
    
  </div>
 
  <!-- <form  id="searchForm">
    <div class="searchCon">
  <button type="button" onclick="performSearch()" class="search" id="search" name="search">Search</button>
  <input  class="inputSearch" id="inputSearch" name="inputSearch" type="text" required>
  </div>
  </form> -->
  <div class="supAdd">
  <button class="addMed" id="addMed" onclick="openSupadd()">Add Supplier</button>
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

    $sql = "SELECT * FROM supplier";
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
            <th></th>
           
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr class = 'text-center' onclick=\"populateForm1(" . $row["sup_Id"] . ", '" . $row["sup_Company"] . "', '" . $row["sup_Address"] . "', '" . $row["sup_Contact_no."] . "', '" . $row["sup_email"]  . "')\">";

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
        <form id="MedForm" action="manageSupplier.php" method="post">
           
        <!-- <label for="supId">Supplier ID:</label>
            <input id="supId" name="supId" class="medId" type="text" readonly> -->

        <div class="input-group mb-4">
            <!-- <span class="input-group-text" id="basic-addon3">Medicine ID</span> -->
            <input type="hidden" class="form-control" name="supId" id="supId" aria-describedby="basic-addon3">
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


            <input id="add" name="add" class="add btn-outline-success" type="submit" value="add">
           
           <input id="update" name="update" class="update btn-outline-primary" type="submit" value="update">
           <input id="delete" name="delete" class="delete btn-outline-warning" type="submit" value="delete">
           <input id="cancel" name="cancel" class="cancel btn-outline-danger" type="button" value="cancel" onclick="closeSupForm()">
           <input id="clear" name="clear" class="clear btn-outline-dark" type="button" value="clear">

        </div>
        </form>
        </div>
    </div>
    </div>
    </div>
</div>
<script src="..//script/manageSup.js"></script>
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