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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    

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
<p class ="text-white">Admin Dashboard</p>
<br>
<div class="imager"></div>
<br>
  <div class="position-sticky">
    <div class="list-group list-group-flush mx-3 mt-4">
   
    <a href="report.php" class="list-group-item list-group-item-action py-2 ripple">
        Reports
      </a>
      <a  id="report" href="manageAcc.php" class="list-group-item list-group-item-action py-2 ripple">
        Manage Accounts
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
  <button class="userHisto bg-primary text-white" id="userHisto" onclick="showHistory()">Logged History</button>
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
                $sql = "SELECT COUNT(*) AS pendingOrder FROM orders WHERE status = 'Pending'";
                $result = $conn->query($sql);
                
                // Step 3: Get the count of expired medicines
                $pendingOrder = 0;
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $pendingOrder = $row['pendingOrder'];
                }
                
                // Step 4: Output the count of expired medicines
                echo "<h3>". $pendingOrder ."</h3>
                
                <p>Pending Orders</p>" ;
                
                // Step 5: Close the database connection
                ?>
            </div>

            <div class="tablinks bg-primary" onclick="openTab(event, 'tab4')">
                <?php 
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                
                // Step 2: Retrieve the medicines with expired dates
                $currentDate = date("Y-m-d");
                $sql = "SELECT COUNT(*) AS pendingAcc FROM accounts WHERE Acc_status = 'pending'";
                $result = $conn->query($sql);
                
                // Step 3: Get the count of expired medicines
                $pendingAcc = 0;
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $pendingAcc = $row['pendingAcc'];
                }
                
                // Step 4: Output the count of expired medicines
                echo "<h3>". $pendingAcc ."</h3>
                
                <p>Pending Accounts</p>" ;
                
                // Step 5: Close the database connection
                ?>
            </div>
    
            <div class="tablinks bg-primary" onclick="openTab(event, 'tab2')">
            <?php 
               if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
      
            // Step 2: Retrieve the medicines with 0 stock
            $sql = "SELECT SUM(trans_total) AS today_total FROM transactions WHERE DATE(trans_date) = '$currentDate' AND archive = 0";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            $todayTotal = 0;
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $todayTotal = $row['today_total'];
            }
            echo "<h3> ₱". number_format($todayTotal, 2) ."</h3>
                
            <p>Todays total Sales</p>" ;
            
            // Step 5: Close the database connection
            ?>
            </div>
            
            <div class="tablinks bg-primary" onclick="openTab(event, 'tab3')">
                    <?php
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    
                    // Step 2: Retrieve all available medicines
                    $sql = "SELECT COUNT(*) AS pendingReq FROM restock_requests WHERE status = 'Pending'";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    // Step 3: Get the count of available medicines
                    $pendingReq = 0;
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $pendingReq = $row['pendingReq'];
                    }
                    
                    // Step 4: Output the count of available medicines  

                    echo "<h3>". $pendingReq ."</h3>
                
                    <p>Restock Request</p>" ;
                    
                    // Step 5: Close the database connection
                 
                    ?>
            </div>
            
        </div>
        <br><br>

    <div class="graphCont" >
      <div class="barGrap" style="width: 100%;">
  <?php
// Step 1: Connect to the MySQL database


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Retrieve the monthly sales data from the database
$sql = "SELECT MONTH(trans_date) AS month, SUM(trans_total) AS total_sales 
        FROM transactions 
        GROUP BY MONTH(trans_date)";
$result = $conn->query($sql);

// Step 3: Organize the data
$data = array();
while($row = $result->fetch_assoc()) {
    $data[$row['month']] = $row['total_sales'];
}

// Step 4: Use Google Charts to generate the bar chart
?>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Month');
            data.addColumn('number', 'Sales');
            data.addRows([
                <?php foreach ($data as $month => $sales) { ?>
                    ['<?php echo date("F", mktime(0, 0, 0, $month, 1)); ?>', <?php echo $sales; ?>],
                <?php } ?>
            ]);

            var options = {
                title: 'Monthly Sales',
                legend: { position: 'none' },
                colors: ['#2196f3'], // Change the color of bars
                hAxis: {
                title: 'Month',
                titleTextStyle: { color: '#333' }, // Change axis title color
                textStyle: { color: '#666' } // Change axis labels color
                },
                vAxis: {
                    title: 'Sales',
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
    <div id="chart_div" style="width: 1000px; height: 500px;"></div>


<?php
// Step 6: Close the database connection

?>  
    </div>

        <div class="douNot"style="width: 100%;">

        <?php
// Step 1: Connect to the MySQL database


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$currentDate = date('Y-m-d');
// Step 2: Retrieve the data
$sql = "SELECT SUM(Med_Quantity) AS total_quantity FROM med_inventory ";
$result = $conn->query($sql);

// Step 3: Get the total quantity
$totalQuantity = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalQuantity = $row['total_quantity'];
}

// Step 4: Generate the chart
?>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Medicine', 'Quantity'],
                ['Total Medicine ', <?php echo $totalQuantity; ?>],
                ['Unused Space', Math.max(0, 1000 - <?php echo $totalQuantity; ?>)] // Ensure no negative values
            ]);

            var options = {
                title: 'Total Medicine Quantity Percentage',
                pieHole: 0.4,
                colors: ['#2196f3','#403f3f'], // Change slice colors
                legend: {
                    textStyle: { color: '#333' } // Change legend text color
                },
                backgroundColor: '#f5f5f5' // Change chart background color
            };

            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data, options);
        }
    </script>

    <div id="donutchart" style="width: 100%; height: 500px;"></div>

<?php
// Step 5: Close the database connection

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

        <div class="overlayHisto" id="overlayHisto">
       
        <div class="userHistory" style="height: 800px;">
        <img src="..//image/icons8-close-50.png" alt="close" height="20px" width="20px" id="closing" onclick="closeHistory()">
        <h2>Logged History</h2>

        <div class="filter-options mb-3">
            <div class="form-check form-check-inline">
                <input class="form-check-input" onclick="filterHistory('users')" type="radio" name="filter" id="filterAll" value="all" checked>
                <label class="form-check-label" for="filterAll">All</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" onclick="filterHistory('users')" name="filter" id="filterToday" value="today">
                <label class="form-check-label" for="filterToday">Today</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" onclick="filterHistory('users')" type="radio" name="filter" id="filterMonth" value="month">
                <label class="form-check-label" for="filterMonth">This Month</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" onclick="filterHistory('users')" name="filter" id="filterYear" value="year">
                <label class="form-check-label" for="filterYear">This Year</label>
            </div>
            <!-- <button type="button" class="btn btn-primary" onclick="filterHistory('users')">Filter</button> -->
        </div>

        <table class="table table-striped table-hover">
        <tr class="table thead-dark text-center">
                <th>Actions</th>
                <th>Date and Time</th>
                <th>Username</th>

            </tr>
            <tbody id="historyTableBody">
            <?php
                    // Initial table load with all data
                    $sqli = "SELECT ua.action, ua.dateTime, ua.Acc_Id, ua.id, acc.Acc_username 
                             FROM useraction ua JOIN accounts acc ON ua.Acc_Id = acc.Acc_Id";
                    $resulti = $conn->query($sqli);

                    if ($resulti->num_rows > 0) {
                        while ($row = $resulti->fetch_assoc()) {
                            echo "<tr class='text-center'>";
                            echo "<td>" . $row["action"] . "</td>";
                            echo "<td>" . $row["dateTime"] . "</td>";
                            echo "<td>" . $row["Acc_username"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No data found</td></tr>";
                    }
                ?>
        </tbody>
        </table>

        </div>
        </div>

        <div class="tableOver" id="tableOver" onclick="closeTab()">
        <div class="tabcontent" id="tab1">
            <h2 class="text-center-dark">Pending Orders</h2>
            <?php 
            

            $sql = "SELECT o.order_id, mi.Med_name, o.quantity, s.sup_Company, u.Acc_username, o.order_date, o.arrival_date, o.status 
            FROM orders o 
            JOIN med_inventory mi ON o.med_id = mi.Med_Id 
            JOIN supplier s ON o.sup_id = s.sup_Id 
            JOIN accounts u ON o.requester_id = u.Acc_id WHERE o.archive = 0";
    $result = $conn->query($sql);
           ?>
       
       <table class="table table-striped table-hover">
        <tr class="table thead-dark text-center">
        <th>Medicine</th>
        <th>Quantity</th>
        <th>Supplier</th>
        <th>Estimated Arrival Date</th>
        <th>Status</th>

    </tr>
    <?php
  

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $currentDate = date('Y-m-d');
            $arrivalDate = $row['arrival_date'];
    
            if ($row['status'] == 'Pending' && $currentDate > $arrivalDate) {
                $row['status'] = 'Overdue';
            }
    
            $rowClass = ($row['status'] == 'Overdue') ? 'overdue' : '';
    
            echo '<tr class="' . $rowClass . '">';
            echo '<td>' . $row['Med_name'] . '</td>';
            echo '<td>' . $row['quantity'] . '</td>';
            echo '<td>' . $row['sup_Company'] . '</td>';
            echo '<td>' . $row['arrival_date'] . '</td>';
            echo '<td>' . $row['status'] . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="9">No orders found</td></tr>';
    }
    ?>
</table>
            <a href="recieving.php" class="btn btn-primary">Manage Orders</a>
        </div>

        <div class = "tabcontent" id="tab2">
        <h2 class="text-center-dark">Transactions Today</h2>
        <?php 

        $sql = "SELECT t.trans_id, t.Med_Id, m.Med_name, t.trans_quan, t.trans_total, t.Acc_Id, a.Acc_username, t.trans_date
        FROM transactions t
        JOIN med_inventory m ON t.Med_Id = m.Med_Id
        JOIN accounts a ON t.Acc_Id = a.Acc_Id
        WHERE DATE(t.trans_date) = CURDATE()";
       
               $result = $conn->query($sql);
           ?>
       
       
       <table class="table table-striped table-hover">
            <thead>
            <tr class="table thead-dark text-center">
                    <!-- <th>Transaction ID</th> -->
                    <th>Medicine name</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Account</th>
                    <th>Transaction Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        // echo '<td>' . $row['trans_id'] . '</td>';
                        echo '<td>' . $row['Med_name'] . '</td>';
                        echo '<td>' . $row['trans_quan'] . '</td>';
                        echo '<td> ₱' . number_format($row['trans_total'], 2) . '</td>';
                        echo '<td>' . $row['Acc_username'] . '</td>';
                        echo '<td>' . $row['trans_date'] . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="6">No transactions found for today.</td></tr>';
                }
                ?>
            </tbody>
        </table>
        <a href="report.php" class="btn btn-primary">Manage transactions</a>
        </div>

        <div class="tabcontent" id="tab3">
        <h2 class="text-center-dark">Restock Request</h2>
        <?php 

            $sql = "SELECT rr.id, mi.Med_name, mi.sup_Id, rr.quantity, u.Acc_username, rr.comments, rr.status 
            FROM restock_requests rr 
            JOIN med_inventory mi ON rr.med_id = mi.Med_Id 
            JOIN accounts u ON rr.requester_id = u.Acc_id WHere rr.archive = 0";
            $result = $conn->query($sql);

        ?>

<table class="table table-striped table-hover">
            <tr class="table thead-dark text-center">
                <th>Medicine</th>
                <th>Quantity</th>
                <th>Requester</th>
                <th>Comments</th>
                <th>Status</th>
         
        </tr>

        <?php

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['Med_name'] . '</td>';
        echo '<td>' . $row['quantity'] . '</td>';
        echo '<td>' . $row['Acc_username'] . '</td>';
        echo '<td>' . $row['comments'] . '</td>';
        echo '<td>' . $row['status'] . '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="6">No restock requests found</td></tr>';
}


?>
    </table>

    <a href="stockRequest.php" class="btn btn-primary">Manage Requests</a>

        </div>

        <div class="tabcontent" id="tab4">
            <h2 class="text-center-dark">Expired Medicine</h2>
            <?php 
            

            $sqli = "SELECT * FROM accounts where Acc_status = 'pending'";
            $resulti = $conn->query($sqli);
       
               $result = $conn->query($sql);
           ?>
       
       <table class="table table-striped table-hover">
        <tr class="table thead-dark text-center">
                <th>Account ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Status</th>
            </tr>
            <?php

        if ($resulti->num_rows > 0) {
            while ($row = $resulti->fetch_assoc()) {
                echo "<tr class = ' text-center' >";
                echo "<td>" . $row["Acc_Id"] . "</td>";
                echo "<td>" . $row["Acc_username"] . "</td>";
                echo "<td>" . $row["Acc_email"] . "</td>";
                echo "<td>" . $row["Acc_status"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No data found</td></tr>";
        }
        
        ?>
        </table>
            <a href="" class="btn btn-primary">Manage Accounts</a>
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