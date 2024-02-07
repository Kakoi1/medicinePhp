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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

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
    <div class="container-lg-12 t-4"> 
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
  <table id="Datatable" class="table table-striped table-hover">
        <tr class="table-dark text-center">
            <th>Med_id</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Expire Date</th>
            <th>Supplier Id</th>
            <th>Action</th>
            <th></th>

        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr class = 'text-center' onclick=\"populateForm(" . $row["Med_Id"] . ", '" . $row["Med_name"] . "', " . $row["Med_price"] . ", " . $row["Med_Quantity"] . ",'" . $row["Med_status"] . "','" . $row["Med_ExpDate"] . "', " . $row["sup_Id"] . ")\">";
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
        <div class="input-group mb-4 md-12 pt-4">
        
        </div>
            <h1 class="text-white">Medicine Form</h1>
            <br>
        <form id="MedForm" action="manage_code.php" method="post">

        <!-- <label for="medId">Medicine ID:</label> -->
            <!-- <input id="medId" name="medId" class="medId" type="text" readonly > -->
       

        <div class="input-group mb-4">
            <!-- <span class="input-group-text" id="basic-addon3">Medicine ID</span> -->
            <input type="hidden" class="form-control" name="medId" id="medId" aria-describedby="basic-addon3" readonly required>
        </div>
            <!-- <label for="cars">Medicine Name:</label>
            <input id="medName" name="medName" class="medName" type="text" required> -->
        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Medicine Name:</span>
            <input type="text" class="form-control" name="medName" id="medName" aria-describedby="basic-addon3" required>
        </div>
            <!-- <label for="price">Medicine Price:</label>
            <input id="price" name="price" class="price" type="number" required> -->
        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Medicine Price:</span>
            <input type="number" class="form-control" name="price" id="price" aria-describedby="basic-addon3"required>
        </div>
            <!-- <label for="quantity">Medicine Quantity:</label>
            <input id="quantity" name="quantity" class="quantity" type="number" required oninput="statChange()"> -->
        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Medicine Quantity:</span>
            <input type="number" class="form-control" name="quantity" id="quantity" aria-describedby="basic-addon3" oninput="statChange()" required>
        </div>   

        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Medicine Status:</span>
           <select name="status" id="status" class="form-select" aria-label="Default select example" required>
           <option selected></option>             
            <option value="Available">Available</option>
            <option value="Out of Stock">Out of Stock</option>
           </select><br>
        </div>
           <!-- <label for="expD">Expire Date:</label>
            <input id="expD" name="expD" class="expD" type="date" required> -->
        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Expiry Date:</span>
            <input type="date" class="form-control" name="expD" id="expD" aria-describedby="basic-addon3" required>
        </div>
        
        <div class="input-group mb-4">
                <span class="input-group-text" id="basic-addon3">Supplier:</span>
            
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

                echo "<select name='supply' id = 'supply' class='form-select' aria-label='Default select example'>";
            
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['sup_Id'] . "'>". $row['sup_Id'] .' '. $row['sup_Company'] . "</option>";
                }
            

                echo "</select>";
            } else {
                echo "No results found";
                }
            
                $conn->close();
                ?>
        </div>

        

        <div class="submitBut">

            <input id="add" name="add" class="add btn-outline-success" type="submit" value="add">
           
            <input id="update" name="update" class="update btn-outline-primary" type="submit" value="update">
            <input id="delete" name="delete" class="delete btn-outline-warning" type="submit" value="delete">
            <input id="cancel" name="cancel" class="cancel btn-outline-danger" type="button" value="cancel" onclick="closeMedupdate()">
            <input id="clear" name="clear" class="clear btn-outline-dark" type="button" value="clear">

            </form>
            
        </div>
        </div>
    </div>
    </div>
</div>
<script src="..//script/manage.js"></script>
<script src="..//script/search.js"></script>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
