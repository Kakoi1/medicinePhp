<?php 


session_start();
$conn = new mysqli("localhost", "root", "", "medicine_inventory");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
   <link rel="stylesheet" type="text/css" href="..//css/mainTable.css?v=1"/>
   <link rel="stylesheet" type="text/css" href="..//css/manage.css?v=1" />
   <link rel="stylesheet" type="text/css" href="..//css/tabStyle.css?v=1"/>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> 
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/date-fns"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script> -->
</head>
<style>
      /* Add your CSS styles here */
      .selected-row {
         background-color: #c5e1a5; /* Change this to your desired color */
         font-weight: bold;
      }
      #forTot{
        font-size: 20px;
        font-weight: bold;
        padding: 10px;
      }
      .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .overlay-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            position: relative;
            width: 80%;
         
        }
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
   </style>
<body >
<div class="containers-lg-12"> 
<nav id="sidebar" class="sidebar d-lg-block sidebar sidebar bg-primary">
<p class ="text-white">Reports  </p>
<br>
<div class="imager"></div>
<br>
  <div class="position-sticky">
    <div class="list-group list-group-flush mx-3 mt-4">
   
      <a href="adminDash.php" class="list-group-item list-group-item-action py-2 ripple">
        Dashboard
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
  

  <div class="tabs">
    <input type="radio" id="tab1" name="tab" checked>
    <label class="tab" for="tab1" onclick="showTab(1)">Sales</label>
    <input type="radio" id="tab2" name="tab">
    <label class="tab" for="tab2" onclick="showTab(2)">Approaching expiry date</label>
    <input type="radio" id="tab3" name="tab">
    <label class="tab" for="tab3" onclick="showTab(3)">Medicine With low stock</label>
</div>

            <div class="content">
                <div class="tab-content tab1-content active">

                <!-- <div class="searchCon1"> -->
<h2>Sales</h2>
<hr>
   
    <!-- </div> -->
    <div class="filter-options mb-3">
            <div class=" form-check form-check-inline">
                <input class="form-check-input" type="radio" name="filter" id="filterAll" onclick="filterHistory('transaction')" value="all" checked>
                <label class="dateCheck form-check-label" for="filterAll">All</label>
            </div>
            <div class=" form-check form-check-inline">
                <input class="form-check-input" type="radio" name="filter" id="filterToday" onclick="filterHistory('transaction')" value="today">
                <label class="dateCheck form-check-label" for="filterToday">Today</label>
            </div>
            <div class=" form-check form-check-inline">
                <input class= "form-check-input" type="radio" name="filter" id="filterMonth" onclick="filterHistory('transaction')" value="month">
                <label class="dateCheck form-check-label" for="filterMonth">This Month</label>
            </div>
            <div class=" form-check form-check-inline">
                <input class="form-check-input" type="radio" name="filter" id="filterYear" onclick="filterHistory('transaction')" value="year">
                <label class="dateCheck form-check-label" for="filterYear">This Year</label>
            </div>
            <!-- <button type="button" class="btn btn-primary" onclick="filterHistory('transaction')">Filter</button> -->
            <form method="post" id="reportIng">
            <br>
            <p style="display:inline">From</p>
                <input id="startDate" name="startDate" class="expD" type="date" required placeholder="Start Date">
                <p style="display:inline"> to </p>
                <input id="endDate" name="endDate" class="expD" type="date" required placeholder="End Date">
                <input type="button" id="submitRep" value="Calculate" class="btn btn-outline-primary">
                <p id = "forTot"></p>
                </form>
            </div>
            <button class="btn btn-outline-primary me-2" id="arcMed" onclick="fetchArchive(1,'trans')">Archive Transactions</button>
            <button class="btn btn-primary" id="fetchNone" onclick=" location.reload()">Refresh</button>
        
      
        <!-- <div class="divCal"> -->
       
        <!-- <button class="genPort btn-primary" style = "border-radius: 8px;" id="genPort" onclick="openReport()">Generate report</button> -->
        <div id="tableData">
    <table id="Datatable" class="table table-striped table-hover">
        <tr class="table-dark text-center">
            <th>Medicine Name</th>
            <th>Medicine Price</th>
            <th>Quantity Sold</th>
            <!-- <th>Expire Date</th> -->
            <th>Acc Name</th>
            <th>Total Price</th>
            
            <th>Date</th>
            <th>action</th>
        </tr>
        <tbody id="historyTableBody">
        <?php

        $sql = "SELECT 
                t.trans_id, 
                t.archive, 
                mi.Med_Id, 
                mi.Med_name,
                mi.Med_price, 
                mi.Med_ExpDate, 
                t.trans_quan,
                t.trans_total, 
                a.Acc_Id, 
                a.Acc_username,
                t.trans_date 
            FROM 
                transactions t
            JOIN 
                med_inventory mi ON t.Med_Id = mi.Med_Id
            JOIN 
                accounts a ON t.Acc_Id = a.Acc_Id  
            WHERE 
                t.archive = 0 
            ORDER BY 
                t.trans_date DESC";
        $result = $conn->query($sql);   

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr class = 'text-center table-dark'  data-user-id = ' ".$row['trans_id']."'>";
                echo "<td>" . $row["Med_name"] . "</td>";
                echo "<td>" . $row["Med_price"] . "</td>";
                echo "<td>" . $row["trans_quan"] . "</td>";
                // echo "<td>" . $row["Med_ExpDate"] . "</td>";
                echo "<td>" . $row["Acc_username"] . "</td>";
                echo "<td>" . $row["trans_total"] . "</td>";
                
                echo "<td>" . $row["trans_date"] . "</td>";
                echo '<td>       
                <button class="delete btn-danger" style = "border-radius: 8px;" name="delete" id="delete">Archive</button>
                </td>';
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
    <h2>Medicines with expiry dates approaching:</h2>
            <table class="table table-striped table-hover" name="tables" id="tables">
            <tr class="table-dark text-center">
                <!-- <th>Medicine Id</th> -->
                <th>Medicine Name</th>
                <th>Expire Date</th> 
                </tr>
    <?php
        if ($resulti->num_rows > 0) {
            while ($row = $resulti->fetch_assoc()) {
                echo"<tr class = 'text-center table-dark '>";
                // echo "<tr onclick=\"populateForm(" . $row["Med_Id"] . ", '" . $row["Med_name"] . "', " . $row["Med_price"] . ", " . $row["Med_Quantity"] . ",'" . $row["Med_status"] . "','" . $row["Med_ExpDate"] . "')\">";
              
                // echo "<td>" . $row["Med_Id"] . "</td>";
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
            <h2>Medicines with Low Stock:</h2>

            <table class="table table-striped table-hover">
            <tr class="table-dark text-center ">
                <!-- <th>Medicine Id</th> -->
                <th>Medicine Name</th>
                <th>Quantity</th> 
                </tr>

    <?php
        if ($resulti->num_rows > 0) {
            while ($row = $resulti->fetch_assoc()) {
                echo"<tr class = 'text-center table-dark '>";
                // echo "<tr onclick=\"populateForm(" . $row["Med_Id"] . ", '" . $row["Med_name"] . "', " . $row["Med_price"] . ", " . $row["Med_Quantity"] . ",'" . $row["Med_status"] . "','" . $row["Med_ExpDate"] . "')\">";
              
                // echo "<td>" . $row["Med_Id"] . "</td>";
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

<div class="overlay" id="overlay">
        <div class="overlay-content">
            <img src="..//image/icons8-close-50.png" alt="close" height="20px" width="20px" class="close-btn" onclick="closeOverlay()">
            <canvas id="salesChart"></canvas>
            <br>
            <p id="totalSales" style="font-weight: bold; margin-top: 10px;"></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>


<script src="..//script/manage.js"></script>

<script>

$(document).ready(function () {
    $("#submitRep").click(function () {
        var formData = $("#reportIng").serialize();
        $.ajax({
            type: "POST",
            url: "salesReport.php",
            data: formData,
            success: function (response) {
                var data = JSON.parse(response);
                // alert(response);
                if (data.error) {
                    document.getElementById("forTot").innerText = data.error;
                } else {
                    openOverlay();
                    renderChart(data.dates, data.sales);
                    document.getElementById("totalSales").innerText = `Total Sales: ${data.totalSales}`;
                }
            },
            error: function (xhr, status, error) {
                alert("Error: " + error);
            }
        });
    });
});
    function renderChart(dates, sales) {
        var ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Sales per Day',
                    data: sales,
                    borderColor: 'rgba(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 1,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'day'
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    
    }
    function openOverlay() {
        document.getElementById("overlay").style.display = "flex";
    }

    function closeOverlay() {
        window.location.href = 'report.php'
    }
    $(document).ready(function(){
    $(document).on('click', '.delete, .rest', function() {
        var userId = $(this).closest('tr').data('user-id');
        var action = $(this).hasClass('delete') ? 'archive' : 'restore';

        $.ajax({
            type: 'POST',
            url: 'transacCode.php',
            data: { userId: userId, action: action },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    alert('Action performed successfully');
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert('Action failed: ' + data.message);
                }
            },
            error: function(xhr, status, error) {
                alert("Error: " + error);
            }
        });
    });

    $(document).on('click', '.deleter', function() {
        var userId = $(this).closest('tr').data('user-id');
        var action = $(this).hasClass('deleter') ? 'delete' : '';

        $.ajax({
            type: 'POST',
            url: 'transacCode.php',
            data: { userId: userId, action: action },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    alert('Action performed successfully');
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert('Action failed: ' + data.message);
                }
            },
            error: function(xhr, status, error) {
                alert("Error: " + error);
            }
        });
    });
});
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