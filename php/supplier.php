
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="..//css/mainTable.css?v=2"/>
    <link rel="stylesheet" type="text/css" href="..//css/manage.css?v=2" />
</head>
<body>
<div class="container"> 
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
<table>
        <tr>
            <th>Supplier Id</th>
            <th>Company</th>
            <th>Address</th>
            <th>Contact No.</th>
            <th>Email</th>
            <th></th>
           
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr onclick=\"populateForm1(" . $row["sup_Id"] . ", '" . $row["sup_Company"] . "', '" . $row["sup_Address"] . "', '" . $row["sup_Contact_no."] . "', '" . $row["sup_email"]  . "')\">";

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
    <img src="..//image/icons8-close-50.png" alt="close" height="20px" width="20px" id="closing" onclick="closeSupForm()">
    <h1> Supplier Form</h1>
        <form id="MedForm" action="manageSupplier.php" method="post">
           
        <label for="supId">Supplier ID:</label>
            <input id="supId" name="supId" class="medId" type="text" readonly>

            <label for="company">Company:</label>
            <input id="company" name="company" class="medName" type="text" required>

            <label for="address">Address:</label>
            <input id="address" name="address" class="price" type="text" required>

            <label for="cont">Contact no.:</label>
            <input id="cont" name="cont" class="quantity" type="text" required>
           
            <label for="email">Email:</label>
            <input id="email" name="email" class="quantity" type="text" required>
           <br>
       
        <div class="submitBut">

            <input id="add" name="add" class="add" type="submit" value="add">
            <input id="update" name="update" class="update" type="submit" value="update">
            <input id="delete" name="delete" class="delete" type="submit" value="delete">
            <input id="clear" name="clear" class="clear" type="submit" value="clear">

        </div>
        </form>
        </div>
    </div>
    </div>
    </div>
</div>
<script src="..//script/manageSup.js"></script>
</body>
</html>