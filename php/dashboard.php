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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="..//css/mainTable.css"> -->
    <link rel="stylesheet" type="text/css" href="..//css/mainTable.css?v=2"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> 
    

     <!-- User Validation if user is Admin -->
    <?php 
 
    if($userN != false){
  
        if ($userN === 'admin'){
            echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                // Display the button for admins
                document.getElementById("userHisto").style.display = "block";
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
      #contents{
        margin-left: 250px;
        transition: all 0.3s;
      }
      @media (max-width: 990px) {
      #sidebar {
        margin-left: -250px;
        transition: all 0.3s;
        /* height: 100vh; */
      }

      #contents {
        margin-left: 0;
        transition: all 0.3s;
      }
      .navbar-nav {
        position: absolute;
        top: 56px;
        left: 0;
        width: 100%;
        background-color: #343a40;
        z-index: 1000;
        padding-bottom: 10px;
        padding: 5px;
      }
   
    }
   </style>
<body >
<div class="containers-lg-12"> 
<nav id="sidebar" class="sidebar d-lg-block sidebar sidebar bg-primary">
<p class ="text-white">Dashboard</p>
<br>
<div class="imager"></div>
<br>
  <div class="position-sticky">
    <div class="list-group list-group-flush mx-3 mt-4">
   
      <a href="mangeStock.php" class="list-group-item list-group-item-action py-2 ripple">
        Manage Inventory
      </a>

      <a href="transactions.php" class="list-group-item list-group-item-action py-2 ripple">
        Transaction
      </a>
      <a href="categories.php" class="list-group-item list-group-item-action py-2 ripple">
        Manage Categories
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
    <button type="button" id="sidebarCollapse" class="btn btn-dark">
    <i class="bi bi-arrow-bar-right"></i>
    </button>

    <div class="btn-group">
    <a class="nav-link dropdown-toggle" style="color: white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"><i class="bi bi-person-square"></i><?php echo '   '.$userN?></a>
        <ul class="dropdown-menu dropdown-menu-dark " aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
          </ul>
          </div>
    <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button> -->
    <div class="medIn">   
    <p class ="text-white">Medicine Inventory</p>
    <div class="logoImg"><img class="logoImg" src="../image/meds.jpg" alt="" width="35px" height="35px"></div>
    </div>
  </nav>
 

 <div class="divi">
    
  <form  id="searchForm">
    <div class="searchCon">
  <!-- <button type="button" onclick="performSearch()" class="search" id="search" name="search">Search</button>
  <input  class="inputSearch" id="inputSearch" name="inputSearch" type="text" required> -->
  </div>
  </form>
  <!-- <button class="userHisto bg-primary text-white" id="userHisto" onclick="showHistory()">Logged History</button> -->
  </div>

  <div class="dashCont">

  <div class="dataNum">
            <div class="tablinks bg-primary" onclick="openTab(event, 'tab1')">
                <?php 
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                
                // Step 2: Retrieve the medicines with expired dates
                $currentDate = date("Y-m-d");
                $sql = "SELECT COUNT(*) AS expired_count FROM med_inventory WHERE Med_ExpDate < '$currentDate'";
                $result = $conn->query($sql);
                
                // Step 3: Get the count of expired medicines
                $expiredCount = 0;
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $expiredCount = $row['expired_count'];
                }
                
                // Step 4: Output the count of expired medicines
                echo "<h3>". $expiredCount ."</h3>
                
                <p>Number of expired medicines </p>" ;
                
                // Step 5: Close the database connection
                ?>
            </div>
    
            <div class="tablinks bg-primary" onclick="openTab(event, 'tab2')">
            <?php 
               if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            // Step 2: Retrieve the medicines with 0 stock
            $sql = "SELECT COUNT(*) AS zero_stock_count FROM med_inventory WHERE Med_Quantity = 0";
            $result = $conn->query($sql);
            
            // Step 3: Get the count of medicines with 0 stock
            $zeroStockCount = 0;
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $zeroStockCount = $row['zero_stock_count'];
            }
            
            // Step 4: Output the count of medicines with 0 stock

            echo "<h3>". $zeroStockCount ."</h3>
                
            <p>Number of medicines with 0 stock</p>" ;
            
            // Step 5: Close the database connection
            ?>
            </div>
            
            <div class="tablinks bg-primary" onclick="openTab(event, 'tab3')">
                    <?php
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    
                    // Step 2: Retrieve all available medicines
                    $sql = "SELECT COUNT(*) AS available_medicines_count FROM med_inventory WHERE Med_Quantity > 0 AND Med_ExpDate >= '$currentDate'";
                    $result = $conn->query($sql);
                    
                    // Step 3: Get the count of available medicines
                    $availableMedicinesCount = 0;
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $availableMedicinesCount = $row['available_medicines_count'];
                    }
                    
                    // Step 4: Output the count of available medicines  

                    echo "<h3>". $availableMedicinesCount ."</h3>
                
                    <p>Number of available medicines</p>" ;
                    
                    // Step 5: Close the database connection
                 
                    ?>
            </div>
            
        </div>
        <br><br>

    <div class="graphCont" >
    <div class="barGrap" style="width: 100%;">
<?php
// Step 1: Connect to the MySQL database
$conn = new mysqli("localhost", "root", "", "medicine_inventory");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Retrieve the most sold medicines data from the database
$sql = "
    SELECT mi.Med_name, SUM(t.trans_quan) AS totalSold 
    FROM transactions t
    JOIN med_inventory mi ON t.Med_Id = mi.Med_Id
    GROUP BY mi.Med_name
    ORDER BY totalSold DESC";
$result = $conn->query($sql);

// Step 3: Organize the data
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = array('name' => $row['Med_name'], 'totalSold' => $row['totalSold']);
}

// Step 4: Use Google Charts to generate the bar chart
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Medicine');
        data.addColumn('number', 'Total Sold Quantity');
        data.addRows([
            <?php foreach ($data as $item) { ?>
                ['<?php echo $item['name']; ?>', <?php echo $item['totalSold']; ?>],
            <?php } ?>
        ]);

        var options = {
            title: 'Most Sold Medicines',
            legend: { position: 'none' },
            colors: ['#2196f3'], // Change the color of bars
            hAxis: {
                title: 'Medicine',
                titleTextStyle: { color: '#333' }, // Change axis title color
                textStyle: { color: '#666' } // Change axis labels color
            },
            vAxis: {
                title: 'Total Sold Quantity',
                titleTextStyle: { color: '#333' }, // Change axis title color
                textStyle: { color: '#666' } // Change axis labels color
            },
            backgroundColor: '#f5f5f5' // Change chart background color
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>

<!-- Step 5: Render the chart on a webpage -->
 <br>
 <br>   
<div id="chart_div" style="width: 100%; height: 500px;"></div>

<?php
// Step 6: Close the database connection
?>
</div>

        </div>


        </div>
    </div>
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
      
          ?>

        <div class="tableOver" id="tableOver" onclick="closeTab()">
        <div class="tabcontent" id="tab1">
            <h2 class="text-center-dark">Expired Medicine</h2>
            <?php 
            

               $sql = "SELECT Med_Id, Med_name, Med_ExpDate FROM med_inventory WHERE Med_ExpDate <= '$currentDate'";
       
               $result = $conn->query($sql);
           ?>
       
                   <table class="table table-striped table-hover" name="tables" id="tables">
                   <tr class="table thead-dark text-center">
                       <th>Medicine Id</th>
                       <th>Medicine Name</th>
                       <th>Expire Date</th> 
                       </tr>
           <?php
               if ($result->num_rows > 0) {
                   while ($row = $result->fetch_assoc()) {
                    echo "<tr class = ' text-center' >";
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
          <a href="mangeStock.php" class="btn btn-primary">Manage Medicine</a>
        </div>

        <div class = "tabcontent" id="tab2">
        <h2 class="text-center-dark">No Stock Medicine</h2>
        <?php 

               $sql = "SELECT Med_Id, Med_name, Med_Quantity FROM med_inventory WHERE Med_Quantity <= 0";
       
               $result = $conn->query($sql);
           ?>
       
                   <table class="table table-striped table-hover" name="tables" id="tables">
                   <tr class="table thead-dark text-center">
                       <th>Medicine Id</th>
                       <th>Medicine Name</th>
                       <th>Quantity</th> 
                       </tr>
           <?php
               if ($result->num_rows > 0) {
                   while ($row = $result->fetch_assoc()) {
                    echo "<tr class = ' text-center' >";
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
           <a href="mangeStock.php" class="btn btn-primary">Manage Medicine</a>
        </div>

        <div class="tabcontent" id="tab3">
        <h2 class="text-center-dark">Available Medicine</h2>
        <?php 

        $sql = "SELECT Med_Id, Med_name, Med_Quantity FROM med_inventory WHERE Med_Quantity > 0 AND  Med_ExpDate >= '$currentDate'";

        $result = $conn->query($sql);
        ?>

            <table class="table table-striped table-hover" name="tables" id="tables">
            <tr class="table thead-dark text-center">
                <th>Medicine Id</th>
                <th>Medicine Name</th>
                <th>Quantity</th> 
                </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr class = '  text-center' >";
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
          <a href="transactions.php" class="btn btn-primary">Add Transaction</a>
        </div>
    </div>

    <script src="..//script/search.js"></script>  
    <script src="..//script/signup.js"></script>
    <script src="..//script/manage.js"></script>     
    
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
      document.getElementById('sidebarCollapse').addEventListener('click', function () {
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('contents');

    if (sidebar.style.marginLeft === '-250px') {
      sidebar.style.marginLeft = '0';
      content.style.marginLeft = '250px';
      
    } else {
      sidebar.style.marginLeft = '-250px';
      content.style.marginLeft = '0';
      
    }
  });
   </script>
   <!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> -->
 
</body>
</html>