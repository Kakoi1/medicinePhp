<?php 

$conn = new mysqli("localhost", "root", "", "medicine_inventory");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT transactions.trans_id, med_inventory.Med_Id, med_inventory.Med_name,
        med_inventory.Med_price, med_inventory.Med_ExpDate, transactions.trans_quan,
        transactions.trans_total, accounts.Acc_Id, accounts.Acc_username,
        transactions.trans_date FROM transactions
        JOIN med_inventory ON transactions.Med_Id = med_inventory.Med_Id
        JOIN accounts ON transactions.Acc_Id = accounts.Acc_Id";
    $result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
   <link rel="stylesheet" type="text/css" href="..//css/mainTable.css?v=1"/>
   <link rel="stylesheet" type="text/css" href="..//css/manage.css?v=1" />
   <link rel="stylesheet" type="text/css" href="..//css/tabStyle.css?v=1"/>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
    <p>Manage Inventory</p>
    <a class="home" href="dashboard.php">HOME</a>
    <a href="mangeStock.php">Manage Inventory</a>
    <a href="supplier.php">Suppliers</a>
    <a href="costumerTransac.php">Transaction</a>
    <a id="account" href="login.php">Log Out</a>
    
  </div>

  <!-- <form  id="searchForm">
    <div class="searchCon">
  <button type="button" onclick="performSearch()" class="search" id="search" name="search">Search</button>
  <input  class="inputSearch" id="inputSearch" name="inputSearch" type="text" required>
  </div>
  </form> -->
  

  <div id="tableData">



  <div class="tabs">
                <div class="tab" onclick="showTab(1)">Sales</div>
                <div class="tab" onclick="showTab(2)">Approaching expiry date</div>
                <div class="tab" onclick="showTab(3)">Medicine With low stock</div>
            </div>

            <div class="content">
                <div class="tab-content tab1-content active">

             

    <table id="Datatable" class="table table-striped table-hover">
        <tr class="table-dark text-center">
            <th>Transaction Id</th>
            <th>Medicine Id</th>
            <th>Medicine Name</th>
            <th>Medicine Price</th>
            <!-- <th>Expire Date</th> -->
            <th>Acc Id</th>
            <th>Acc Name</th>
            <th>Total Price</th>
            <th>Quantity Sold</th>
            <th>Date</th>
        </tr>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr class = 'text-center' onclick=\"idtoDelete(" . $row["trans_id"] . ")\">";
                echo "<td>" . $row["trans_id"] . "</td>" ;
                echo "<td>" . $row["Med_Id"] . "</td>";
                echo "<td>" . $row["Med_name"] . "</td>";
                echo "<td>" . $row["Med_price"] . "</td>";
                // echo "<td>" . $row["Med_ExpDate"] . "</td>";
                echo "<td>" . $row["Acc_Id"] . "</td>";
                echo "<td>" . $row["Acc_username"] . "</td>";
                echo "<td>" . $row["trans_total"] . "</td>";
                echo "<td>" . $row["trans_quan"] . "</td>";
                echo "<td>" . $row["trans_date"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No data found</td></tr>";
        }
        ?>
        </tbody>
        </table>
                 
        <div class="searchCon1">
    <button class="genPort btn-outline-primary" id="genPort" onclick="openReport()">Generate report</button>
    <form action="transacCode.php" method="post">
    <button class="delete btn-outline-warning" name="delete" id="delete">Delete</button>
    <input  class="inputSearch" id="inputSearch" name="inputSearch" type="hidden" readonly>
    </form>
    </div>
            
                </div>
                
                <div class="tab-content tab2-content">
                 
                <?php 
        $conn = new mysqli("localhost", "root", "", "medicine_inventory");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $currentDate = date('Y-m-d');

        $sqli = "SELECT Med_Id, Med_name, Med_ExpDate FROM med_inventory WHERE Med_ExpDate >= '$currentDate' AND Med_ExpDate <= DATE_ADD('$currentDate', INTERVAL 30 DAY)";

        $resulti = $conn->query($sqli);
    ?>

        <label for="tables">Medicines with expiry dates approaching:</label>
            <table class="table table-striped table-hover" name="tables" id="tables">
            <tr class="table-dark text-center">
                <th>Medicine Id</th>
                <th>Medicine Name</th>
                <th>Expire Date</th> 
                </tr>
    <?php
        if ($resulti->num_rows > 0) {
            while ($row = $resulti->fetch_assoc()) {
                echo"<tr class = 'text-center'>";
                // echo "<tr onclick=\"populateForm(" . $row["Med_Id"] . ", '" . $row["Med_name"] . "', " . $row["Med_price"] . ", " . $row["Med_Quantity"] . ",'" . $row["Med_status"] . "','" . $row["Med_ExpDate"] . "')\">";
              
                echo "<td>" . $row["Med_Id"] . "</td>";
                echo "<td>" . $row["Med_name"] . "</td>";
              
                echo "<td>" . $row["Med_ExpDate"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No Expire Medicine</td></tr>";
        }

    ?>

            </table>

                </div>

                <div class="tab-content tab3-content">
                <?php 
        $conn = new mysqli("localhost", "root", "", "medicine_inventory");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $lowStock = 10;

        $sqli = "SELECT * FROM med_inventory WHERE Med_Quantity < '$lowStock'";

        $resulti = $conn->query($sqli);
    ?>
            <br>
            <label for="tables">Medicines with Low Stock:</label>

            <table class="table table-striped table-hover">
            <tr class="table-dark text-center">
                <th>Medicine Id</th>
                <th>Medicine Name</th>
                <th>Quantity</th> 
                </tr>

    <?php
        if ($resulti->num_rows > 0) {
            while ($row = $resulti->fetch_assoc()) {
                echo"<tr class = 'text-center'>";
                // echo "<tr onclick=\"populateForm(" . $row["Med_Id"] . ", '" . $row["Med_name"] . "', " . $row["Med_price"] . ", " . $row["Med_Quantity"] . ",'" . $row["Med_status"] . "','" . $row["Med_ExpDate"] . "')\">";
              
                echo "<td>" . $row["Med_Id"] . "</td>";
                echo "<td>" . $row["Med_name"] . "</td>";
              
                echo "<td>" . $row["Med_Quantity"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No Expire Medicine</td></tr>";
        }

    ?>

            </table>
                
    </div>
   
    </div>

 
    </div>

    </div>
</div>




<div class="overlay" id="overHer">

<?php 

$conn = new mysqli("localhost", "root", "", "medicine_inventory");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT transactions.trans_id, med_inventory.Med_Id, med_inventory.Med_name,
        med_inventory.Med_price, med_inventory.Med_ExpDate, transactions.trans_quan,
        transactions.trans_total, accounts.Acc_Id, accounts.Acc_username,
        transactions.trans_date FROM transactions
        JOIN med_inventory ON transactions.Med_Id = med_inventory.Med_Id
        JOIN accounts ON transactions.Acc_Id = accounts.Acc_Id";
    $result = $conn->query($sql);

?>

        <div class="reportGen">
        <img src="..//image/icons8-close-50.png" alt="close" height="20px" width="20px" id="closing" onclick="closeReport()">

      

        <label for="tables">Calculate daily Sales</label>
        <div class="divCal">
        <form method="post" action="salesReport.php">
            <br>
            <p style="display:inline">From</p>
                <input id="startDate" name="startDate" class="expD" type="date" required placeholder="Start Date">
                <p style="display:inline"> to </p>
                <input id="endDate" name="endDate" class="expD" type="date" required placeholder="End Date">
                <input type="submit" value="Calculate" class="btn btn-outline-primary">
                </form>
            </div>
    <table class="table table-striped table-hover">
        <tr class="table-dark text-center">
            <th>Transaction Id</th>
            <th>Medicine Id</th>
            <th>Medicine Name</th>
            <th>Medicine Price</th>
            <!-- <th>Expire Date</th> -->
            <th>Acc Id</th>
            <th>Acc Name</th>
            <th>Total Price</th>
            <th>Quantity Sold</th>
            <th>Date</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr class='text-center'>";
                echo "<td>" . $row["trans_id"] . "</td>" ;
                echo "<td>" . $row["Med_Id"] . "</td>";
                echo "<td>" . $row["Med_name"] . "</td>";
                echo "<td>" . $row["Med_price"] . "</td>";
                // echo "<td>" . $row["Med_ExpDate"] . "</td>";
                echo "<td>" . $row["Acc_Id"] . "</td>";
                echo "<td>" . $row["Acc_username"] . "</td>";
                echo "<td>" . $row["trans_total"] . "</td>";
                echo "<td>" . $row["trans_quan"] . "</td>";
                echo "<td>" . $row["trans_date"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No data found</td></tr>";
        }
        ?>
        </table>
        <br>
   
        </div>
        </div>



        <script src="..//script/manage.js">

        </script>
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