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
</head>
<body>
<div class="container">
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
  <div class="searchCon1">
    <button class="genPort" id="genPort" onclick="openReport()">Generate report</button>
    <form action="transacCode.php" method="post">
    <button class="delete" name="delete" id="delete">Delete</button>
    <input  class="inputSearch" id="inputSearch" name="inputSearch" type="hidden" readonly>
    </form>
  </div>

  <div id="tableData">
  <table id="Datatable">
        <tr>
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
                echo "<tr onclick=\"idtoDelete(" . $row["trans_id"] . ")\">";
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
    </div>

    </div>
</div>




<div class="overlay" id="overHer">

    <?php 
        $conn = new mysqli("localhost", "root", "", "medicine_inventory");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $currentDate = date('Y-m-d');

        $sqli = "SELECT Med_Id, Med_name, Med_ExpDate FROM med_inventory WHERE Med_ExpDate >= '$currentDate' AND Med_ExpDate <= DATE_ADD('$currentDate', INTERVAL 30 DAY)";

        $resulti = $conn->query($sqli);
    ?>

        <div class="reportGen">
        <img src="..//image/icons8-close-50.png" alt="close" height="20px" width="20px" id="closing" onclick="closeReport()">
        <label for="tables">Medicines with expiry dates approaching:</label>
            <table class="tableData" name="tables" id="tables">
                <tr>
                <th>Medicine Id</th>
                <th>Medicine Name</th>
                <th>Expire Date</th> 
                </tr>
    <?php
        if ($resulti->num_rows > 0) {
            while ($row = $resulti->fetch_assoc()) {
                echo"<tr\>";
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

            <table>
            <tr>
                <th>Medicine Id</th>
                <th>Medicine Name</th>
                <th>Quantity</th> 
                </tr>

    <?php
        if ($resulti->num_rows > 0) {
            while ($row = $resulti->fetch_assoc()) {
                echo"<tr\>";
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

            <?php 
        $conn = new mysqli("localhost", "root", "", "medicine_inventory");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $lowStock = 10;

        $sqli = "SELECT * FROM med_inventory ";

        $resulti = $conn->query($sqli);
    ?>
            <br>
            <label for="tables">Medicines Current Stock:</label>

            <table id="Datatable">
        <tr>
            <th>Med_id</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Expire Date</th>
            <th>Supplier Id</th>

        </tr>

        <?php
        if ($resulti->num_rows > 0) {
            while ($row = $resulti->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["Med_Id"] . "</td>" ;
                echo "<td>" . $row["Med_name"] . "</td>";
                echo "<td>" . $row["Med_price"] . "</td>";
                echo "<td>" . $row["Med_Quantity"] . "</td>";
                echo "<td>" . $row["Med_status"] . "</td>";
                echo "<td>" . $row["Med_ExpDate"] . "</td>";
                echo "<td>" . $row["sup_Id"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No data found</td></tr>";
        }
        ?>
    </table>
</div>
</div>




        <script src="..//script/manage.js">

        </script>
</body>
</html>