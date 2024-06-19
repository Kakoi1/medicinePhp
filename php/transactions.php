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
        $categories = [];
        $sql = "SELECT * FROM categories";
        $results = $conn->query($sql);
        if ($results->num_rows > 0) {
            while ($rows = $results->fetch_assoc()) {
                $categories[] = $rows['name'];
            }
        }

}else{
    echo "<script>alert('no data found');
    document.location.href = 'logout.php';
</script>";

}

$currentDate = date("Y-m-d");

$sql = "SELECT  mi.Med_Id, mi.Med_name, s.sup_Company, mi.type, mi.category, mi.Med_price, mi.Med_Quantity, mi.Med_status, mi.Med_ExpDate, mi.sup_Id, mi.archive FROM `med_inventory` mi 
            LEFT JOIN supplier s ON mi.sup_Id = s.sup_Id 
            WHERE mi.Med_Quantity > 0 AND  mi.Med_ExpDate >= '$currentDate' AND mi.archive = 0";

$result = $conn->query($sql);

$medicineForms = [
    'Tablets',
    'Capsules',
    'Liquids',
    'Topicals',
    'Injectables',
    'Inhalers',
    'Suppositories',
    'Patches',
    'Eye/Ear Drops',
    'Nasal Sprays',
    'Lozenges',
    'Powders'
];

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">     
     <!-- User Validation if user is Admin -->
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

</head>
<style>

   </style>
 
 <body >
<div class="containers-lg-12"> 
<nav id="sidebar" class="sidebar d-lg-block sidebar sidebar bg-primary">
<p class ="text-white">Transaction</p>
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
      <a href="categories.php" class="list-group-item list-group-item-action py-2 ripple">
        Manage Categories
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
          <form class="d-flex " role="search">   
        
        <input class="form-control me-2" type="search" oninput="transacSearch()" id="inputSearch" name="inputSearch" placeholder="Search" aria-label="Search">
        <div class="btn-group">
        <!-- <button class="btn btn-outline-success me-2" type="button" onclick="">Search</button> -->
        <button class="btn btn-outline-success dropdown-toggle" type="button" data-bs-toggle="dropdown"  aria-expanded="false">
                Filter
            </button>
            <ul class="dropdown-menu dropdown-menu-dark p-2 " id="categoryDropdown">
            <?php
                echo '<div class="rows">';
                echo '<div class="cols">';
                echo'Category:';
                foreach ($categories as $category) {
                    echo "<li><label class='dropdown-item'><input onclick='transacSearch()' type='checkbox' class='category-checkbox' value='$category'> $category</label></li>";
                }
                echo '</div>';
                // echo '<hr>';
                echo '<div class="cols">';
                echo'Type:';
                echo "<li><label class='dropdown-item'><input onclick='transacSearch()' type='radio' name='type' class='type-radio' value='all'>All</label></li>";
                foreach ($medicineForms as $form) {
                    echo "<li><label class='dropdown-item'><input onclick='transacSearch()' type='radio' name='type' class='type-radio' value='$form'> $form</label></li>";
                }
                echo '</div>';
                echo '</div>';
                ?>
            </ul>
        </div>
    </form>
    
          <div class="medIn">   
    <p class ="text-white">Medicine Inventory</p>
    <div class="logoImg"><img class="logoImg" src="../image/meds.jpg" alt="" width="35px" height="35px"></div>
    </div>
  </nav>
  <div class="divi">

    <div>
        <button class="items" id="items" onclick="showCheck()">Check Out</button>
    </div>
   
    </div>
  
  <div id="tableData">
  <table id="Datatable" class="table table-striped table-hover">
  <tr class="table-dark text-center">
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Supplier</th>
            <th>Expire Date</th>
            <th>Type</th>
            <th>Category</th>
            <th>Action</th>

        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr class = 'table-dark text-center' >";
                echo "<td>" . $row["Med_name"] . "</td>";
                echo "<td>" . $row["Med_price"] . "</td>";
                echo "<td>" . $row["Med_Quantity"] . "</td>";
                echo "<td>" . $row["Med_status"] . "</td>";
                echo "<td>" . $row["sup_Company"] . "</td>";
                echo "<td>" . $row["Med_ExpDate"] . "</td>";
                echo "<td>" . $row["type"] . "</td>";
                echo "<td>" . $row["category"] . "</td>";
                echo "<td> <button class='addMed btn-primary' id='addMed' onclick=\"populateForm(" . $row["Med_Id"] . ", '" . $row["Med_name"] . "', " . $row["Med_price"] . ", " . $row["Med_Quantity"] . ",'" . $row["Med_status"] . "','" . $row["Med_ExpDate"] . "')\"'>Buy</button></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No data found</td></tr>";
        }
        ?>
    </table>
   
   

    </div>
    <form action="" method ='post'>
    <div class="medTransac" id="medTransac">
        
        <div class="transacForm" id ='tranForm'>
        <div class="input-group mt-4 md-12">
            <h1 class="text-white">Add Transaction</h1>
        </div>
        <!-- <form id="MedForm" action="transacCode.php" method="post"> -->

        <div class="row gy-3">

           <div class="col">


            <input id="medId" name="medId" class="medId" type="hidden" readonly required>



        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Medicine Name:</span>
            <input type="text" class="form-control" name="medName" id="medName" aria-describedby="basic-addon3" required readonly>
        </div>


            <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Medicine Price:</span>
            <input type="number" class="form-control" name="price" id="price" aria-describedby="basic-addon3"required readonly>
        </div>

        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Medicine Quantity:</span>
            <input type="number" class="form-control" name="quantity" id="quantity" aria-describedby="basic-addon3" readonly required>
        </div>   

        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Medicine Status:</span>
            <input type="text" class="form-control" name="status" id="status" aria-describedby="basic-addon3" readonly required>
        </div> 



        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Expiry Date:</span>
            <input type="date" class="form-control" name="expD" id="expD" aria-describedby="basic-addon3" readonly required>
        </div> 
            
            </div>
          


          
            <div class="col">

        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Quantity:</span>
            <input type="number" class="form-control" name="quanBuy" id="quanBuy" aria-describedby="basic-addon3" required oninput="calculateTotalPrice()">
        </div>

        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Total Price:</span>
            <input type="number" class="form-control" name="tPrice" id="tPrice" aria-describedby="basic-addon3" required readonly>
        </div>

            
        <!-- <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Cash:</span>
            <input type="number" class="form-control" name="cash" id="cash" aria-describedby="basic-addon3" required onchange="calculateChange()">
        </div>

        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Total Change:</span>
            <input type="number" class="form-control" name="change" id="change" aria-describedby="basic-addon3" required readonly>
        </div> -->

            </div>
    </div>
        <div class="submitBut">

            <input id="Buyin" name="Buyin" class="add btn-primary" type="button" value="Buy" onclick="saveItem()">
            <input id="cancel" name="cancel" class="cancel btn-outline-primary" type="button" value="cancel" onclick="closeTransac()">
     

        </div>
        <!-- </form> -->

        
            


        </div>\
       
        
        </div>
        </form>

        <div class = 'checkout' id="cheOut">
            <div class="overCheck">
                <form action="" method="post">
            <div class="entries" id="entries">
            <div class="labels"><h3>Medicine Name</h3> <h3>Quantity</h3> <h3>Price</h3></div>
      
            </div>
            <div class="rows">
            <div class="col-sm-4">
            <button type="submit" id="buyy" onclick="completeTransaction();" name="buyy">Check Out</button>

            <button type="button" id="cael" name ='cael' onclick="closeCheck()">Add More</button>
            </div>
            <div class="col-md-4">
            <label for="totalPrice">Total Price:</label>
            <input type="text" id ="totalPrice">
            </div>
            </div>
            </form>
            </div>
        </div>

       
    </div>
</div>
<script src="..//script/manage.js"></script>

<script>
    let totalProd = 0;
    var addedProducts = {};
    let totalPri = 0;

    function saveItem() {
     document.getElementById('medTransac').style.display = 'flex';
    let ids = document.getElementById('medId').value;
   let names = document.getElementById('medName').value;
    let prices = document.getElementById('price').value;
    let quant = document.getElementById('quantity').value;
    let stats = document.getElementById('status').value;
    let dat = document.getElementById('expD').value;
    let quns = document.getElementById('quanBuy').value;
    let totap = document.getElementById('tPrice').value;
    

    if(quns === "" || totap === ""){
        alert('all Fields must be inputed');
    }
    else if(quns == 0 || totap == 0){
        alert('Invalid Input');
    }else{
        let entries =  document.getElementById('entries');
    var entry = document.createElement('div');
    entry.className = 'entry';
    // entry.innerHTML = '<p name = "id[]">'+ids+'</p> <p name ="names[]">'+names+'</p> <p name = "quns[]" >'+quns+'</p> <p name = "totap[]">'+totap+'</p>';
    entry.innerHTML = '<input type="hidden" name="id[]" value = '+ids+'> <input type="hidden" name ="prodQuant[]" value = '+quant+'> <input type="text" name="names[]" value ='+names+'> <input type="number" name="quns[]" value ='+quns+'> <input type="text" name="totap[]" value ='+totap+'> <input type="hidden" name ="stat[]" value = '+stats+'>';
    

    var removeButton = document.createElement('button');
            removeButton.textContent = 'Remove';
            removeButton.onclick = function() {
                entry.remove();
                // changepri(-parseFloat(totap));
                updateTotalProducts(-1,-parseFloat(totap) );
                addedProducts[names] = false; // Product becomes clickable again
                enableButton(names);
            };
            if (!addedProducts[names]) {
                entry.appendChild(removeButton);
                entries.appendChild(entry);
                // changepri(parseFloat(totap));
                updateTotalProducts(1, parseFloat(totap)); 
                addedProducts[names] = true; // Mark product as added
                disableButton(names);
                showCheck()
            }else{
                alert("medicine Already Added");
            }

        function updateTotalProducts(count, price) {
            totalProd += count;
            totalPri += price;
            if(totalProd <= 0){
            document.getElementById('items').style.display = 'none';
            document.getElementById('cheOut').style.display = 'none';
            }else{
            document.getElementById('items').textContent = 'Check Out(' +totalProd+')';
            document.getElementById('items').style.display = 'block';
            }
            document.getElementById('totalPrice').value =totalPri;
        }

        function disableButton(names) {
            document.getElementById('addMed' + names.replace(/ /g, '')).disabled = true;
        }

        function enableButton(names) {
            document.getElementById('addMed' + names.replace(/ /g, '') ).disabled = false;
        }
    }
}

// function changePri(price){
//         totalPrice += price; 
//         console.log("Total price: " + totalPrice);
//     }   

Buyin.addEventListener('click', closeTrans);
 
function closeTrans(){
    document.getElementById('medTransac').style.display = 'none';
    document.getElementById('cheOut').style.display = 'flex';
    let quns = document.getElementById('quanBuy').value = "";
    let totap = document.getElementById('tPrice').value = "";
}


function showCheck(){
        document.getElementById('cheOut').style.display = 'flex';
    }
    function closeCheck(){
        document.getElementById('cheOut').style.display = 'none';
    }

</script>

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
        let totalPrice = quan * price;

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
  <!-- <script>
    function completeTransaction() {
        alert('Transaction Complete.');
        console.log('Redirecting...');
        window.location.href = 'dashboard.php';
         // Prevent default form submission behavior
    }
</script> -->
</body>
</html>

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicine_inventory";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $totalProd = 0;
    $medId = $_POST['id'];
    $quant = $_POST['quns'];
    $totals = $_POST['totap'];
    $names = $_POST['names'];
    $quanTobuy = $_POST['prodQuant'];
    $stat = $_POST['stat'];
    $userID = $_SESSION['user_id'];
    $alert = 0;

    if (isset($_POST['buyy'])) {
        
        for ($i = 0; $i < count($names); $i++) {
            $Ids = $medId[$i];
            $quants = $quant[$i];
            $total = $totals[$i];
            $tobuys = $quanTobuy[$i];
            $stats = $stat[$i];

            $totalProd =  ($tobuys - $quants);

            $sql = "INSERT INTO `transactions`(`Med_Id`, `trans_quan`, `trans_total`, `Acc_Id`, `trans_date`) VALUES ('$Ids', '$quants', '$total','$userID',NOW())";

            if (mysqli_query($conn, $sql)) {

                if ($totalProd <= 0) {

                    $sqli = "UPDATE `med_inventory` SET `Med_Quantity`='$totalProd',`Med_status`='Out of Stock' WHERE `Med_Id`='$Ids'";

                    if (mysqli_query($conn, $sqli)) {
                        $alert += 1;
                    }
                } else {

                    $sqli = "UPDATE `med_inventory` SET `Med_Quantity`='$totalProd',`Med_status`='$stats' WHERE `Med_Id`='$Ids'";

                    if (mysqli_query($conn, $sqli)) {

                        $alert += 1;
                    }
                }
            }
        }

        if ($alert > 0) {
           
            // Start output buffering
            $sql = "INSERT INTO `useraction`(`action`, `dateTime`, `Acc_Id`) VALUES ('Add Transaction', current_timestamp(), $userID)";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            echo "<script>alert('transaction success');var printPageURL = 'printPage.php';
            window.open(printPageURL, '_blank');</script>";

            $_SESSION['names'] = $names;
            $_SESSION['quant'] = $quant;
            $_SESSION['totals'] = $totals;

            echo "<script>alert('transaction success'); window.location.href = 'dashboard.php'; </script>";
        }
    }
}
?>
