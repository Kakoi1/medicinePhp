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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

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

     [class*="input-group-text"]{
        font-weight: bold;
        border-radius: 8px;
     }
    #price{
        background-color: #2b2a2aaf;
        color: white;
        border: solid 1px;
        border-radius: 8px,0px,8px,8px;
    }
    #medName{
        background-color: #2b2a2aaf;
        color: white;
        border: solid 1px;
        border-radius: 8px,0px,8px,8px;
    }
    #status{
        background-color: #2b2a2aaf;
        color: white;
        border: solid 1px;
        border-radius: 8px,0px,8px,8px;;
    }
    #quantity{
        background-color: #2b2a2aaf;
        color: white;
        border: solid 1px;
        border-radius: 8px,0px,8px,8px;
    }
    #expD{
        background-color: #2b2a2aaf;
        color: white;
        border: solid 1px;
        border-radius: 8px,0px,8px,8px;
    }
    #tPrice{
        background-color: #2b2a2aaf;
        color: white;
        border: solid 1px;
        border-radius: 8px,0px,8px,8px;
    }
    #change{
        background-color: #2b2a2aaf;
        color: white;
        border: solid 1px;
        border-radius: 8px,0px,8px,8px;
    }
     
   </style>
 
<body>
<div class="container-lg-12 mt-4">  
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
  <table id="Datatable" class="table table-striped table-hover">
  <tr class="table-dark text-center">
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
                echo "<tr class = 'text-center' onclick=\"populateForm(" . $row["Med_Id"] . ", '" . $row["Med_name"] . "', " . $row["Med_price"] . ", " . $row["Med_Quantity"] . ",'" . $row["Med_status"] . "','" . $row["Med_ExpDate"] . "')\">";
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
        <div class="input-group mt-4 md-12">
            <h1 class="text-white">Add Transaction</h1>
        </div>
        <form id="MedForm" action="transacCode.php" method="post">

        <div class="row gy-3">

           <div class="col">

        <!-- <label for="medId">Medicine ID:</label> -->
            <input id="medId" name="medId" class="medId" type="hidden" readonly required>

            <!-- <label for="cars">Medicine Name:</label>
            <input id="medName" name="medName" class="medName" type="text" required readonly> -->

        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Medicine Name:</span>
            <input type="text" class="form-control" name="medName" id="medName" aria-describedby="basic-addon3" required readonly>
        </div>

            <!-- <label for="price">Medicine Price:</label>
            <input id="price" name="price" class="price" type="number" required readonly> -->

            <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Medicine Price:</span>
            <input type="number" class="form-control" name="price" id="price" aria-describedby="basic-addon3"required readonly>
        </div>

        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Medicine Quantity:</span>
            <input type="number" class="form-control" name="quantity" id="quantity" aria-describedby="basic-addon3" readonly required>
        </div>   

            <!-- <label for="quantity">Medicine Quantity:</label>
            <input id="quantity" name="quantity" class="quantity" type="number" required readonly> -->

            <!-- <label for="status">Status:</label><br>
            <input id="status" name="status" class="status" type="text" required readonly> -->

        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Medicine Status:</span>
            <input type="text" class="form-control" name="status" id="status" aria-describedby="basic-addon3" readonly required>
        </div> 

            <!-- <label for="expD">Expire Date:</label>
            <input id="expD" name="expD" class="expD" type="date" required readonly> -->

        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Expiry Date:</span>
            <input type="date" class="form-control" name="expD" id="expD" aria-describedby="basic-addon3" readonly required>
        </div> 
            
            </div>
          
           <!-- <select name="status" id="status" class="status" readonly>
                <option value="out of stock">Out of Stock</option>
                <option value="available">Available</option>
           </select><br> -->
          
            <div class="col">
            <!-- <label for="quanBuy">Quantity :</label>
            <input id="quanBuy" name="quanBuy" class="quanBuy" type="number" required oninput="calculateTotalPrice()"> -->

        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Quantity:</span>
            <input type="number" class="form-control" name="quanBuy" id="quanBuy" aria-describedby="basic-addon3" required oninput="calculateTotalPrice()">
        </div>
        
            <!-- <label for="tPrice">Total Price:</label>
            <input id="tPrice" name="tPrice" class="tPrice" type="number" required readonly>
             -->
        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Total Price:</span>
            <input type="number" class="form-control" name="tPrice" id="tPrice" aria-describedby="basic-addon3" required readonly>
        </div>

            <!-- <label for="cash">Cash:</label>
            <input id="cash" name="cash" class="cash" type="number" required onchange="calculateChange()"> -->
            
        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Cash:</span>
            <input type="number" class="form-control" name="cash" id="cash" aria-describedby="basic-addon3" required onchange="calculateChange()">
        </div>

            <!-- <label for="change">Change:</label>
            <input id="change" name="change" class="change" type="number" required readonly>
            <br> -->

        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Total Change:</span>
            <input type="number" class="form-control" name="change" id="change" aria-describedby="basic-addon3" required readonly>
        </div>

            </div>
    </div>
        <div class="submitBut">

            <input id="Buyin" name="Buyin" class="add btn-outline-success" type="submit" value="Buy">
            <input id="cancel" name="cancel" class="cancel btn-outline-danger" type="button" value="cancel" onclick="closeTransac()">
     

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