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
                $userID = $row['Acc_Id'];
              
            }

            $categories = [];
            $sql = "SELECT * FROM categories";
            $results = $conn->query($sql);
            if ($results->num_rows > 0) {
                while ($rows = $results->fetch_assoc()) {
                    $categories[] = $rows['name'];
                }
            }
          
            $sqls = "SELECT * FROM med_inventory WHERE Med_Quantity < 20";
            $results = $conn->query($sqls);
            $medicines = [];
            if ($results->num_rows > 0) {
                $medicines = $results->fetch_all(MYSQLI_ASSOC);
            }      

    }else{
        echo "<script>alert('no data found');
        document.location.href = 'logout.php';
    </script>";
    }
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
    $sql = "SELECT COUNT(*) AS completed_orders_count FROM orders WHERE status = 'Completed'";
$result = $conn->query($sql);
$completedOrdersCount = 0;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $completedOrdersCount = $row['completed_orders_count'];
}

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> 
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
    
    $sql = "SELECT  mi.Med_Id, mi.Med_name, s.sup_Company, mi.type, mi.category, mi.Med_price, mi.Med_Quantity, mi.Med_status, mi.Med_ExpDate, mi.sup_Id, mi.archive FROM `med_inventory` mi 
 
            LEFT JOIN supplier s ON mi.sup_Id = s.sup_Id
            WHERE mi.archive = 0 ";

    $result = $conn->query($sql);   
   
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
     .popup {
    display: flex; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 9999; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  }
  .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
      position: relative;
      bottom: -10px;
  }
  .poping{
   display: none;
   color: red;
   text-align: center;
   font-weight: bold;
   width: 100%;
   background: #FFCCCC; 
   padding: 10px;
   border: 1px solid black;
   border-radius: 5px; 
   box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
  }
  #mySelect{
    width: 100px !important;
  }
  #overlayer {
            position: fixed;
            display: none; /* Hidden by default */
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5); /* Black with opacity */
            z-index: 1; /* Specify a stack order in case you're using a different order for other elements */
        }
        #restockRequestFormContainer {
            display: none; /* Hidden by default */
            position: fixed;
            width: 700px;
            height: 500px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #575454c2;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            z-index: 2; /* Ensures the form is above the overlay */
        }
        .overlayed {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 70%;
            /* max-width: 600px; */
        }

        .closed-btn {
            float: right;
            cursor: pointer;
        }
   </style>
<body >
<div class="containers-lg-12"> 
<nav id="sidebar" class="sidebar d-lg-block sidebar sidebar bg-primary">
<p class ="text-white">Manage Inventory</p>
<br>
<div class="imager"></div>
<br>
  <div class="position-sticky">
    <div class="list-group list-group-flush mx-3 mt-4">
   
      <a href="dashboard.php" class="list-group-item list-group-item-action py-2 ripple">
        Dashboard
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
        
        <input class="form-control me-2" type="search" oninput="performSearch()" id="inputSearch" name="inputSearch" placeholder="Search" aria-label="Search">
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
                    echo "<li><label class='dropdown-item'><input onclick='performSearch()' type='checkbox' class='category-checkbox' value='$category'> $category</label></li>";
                }
                echo '</div>';
                // echo '<hr>';
                echo '<div class="cols">';
                echo'Type:';
                echo "<li><label class='dropdown-item'><input onclick='performSearch()' type='radio' name='type' class='type-radio' value='all'>All</label></li>";
                foreach ($medicineForms as $form) {
                    echo "<li><label class='dropdown-item'><input onclick='performSearch()' type='radio' name='type' class='type-radio' value='$form'> $form</label></li>";
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
    <button class="btn btn-outline-primary me-2 addmed" id="addMed" onclick="openMedadd()">Add Medicine</button>
    <button class="btn btn-outline-primary me-2" id="arcMed" onclick="fetchArchive(1,'medicine')">Archived Medicine</button>
    <button type="button" id="requestRestockBtn" class="btn btn-primary me-2" data-toggle="modal" data-target="#restockRequestModal">
    Request Restock 
</button>
    <button class="btn btn-primary" id="fetchNone" onclick="window.location.href = 'mangeStock.php'">Refresh</button>
    <button class="btn btn-primary" id="fetchOrder" onclick="openReplenish()">Replenish Stock  
    <?php if ($completedOrdersCount > 0): ?>
                <span class="badge bg-danger "><?php echo $completedOrdersCount; ?></span>
    <?php endif; ?>
    </button>
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
                echo "<td> 
                <div class ='butoon'><button id = 'edit' class = 'editButon btn btn-primary' name = 'updates'onclick=\"populateForm1(" . $row["Med_Id"] . ", '" . $row["Med_name"] . "', " . $row["Med_price"] . ", " . $row["Med_Quantity"] . ",'" . $row["Med_ExpDate"] . "', " . $row["sup_Id"] . ", '" . $row["category"] . "', '" . $row["type"] . "')\"'>Edit</button> 
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
        <h1 class="text-white">Medicine Form</h1>
        <br>
        <form id="medicineForm" >
            <div id="medInputs">
                <?php

                    // Display default input fields if no submitted data exists
                    echo '<div class="medicines">';
                    echo '<div class="input-group mb-4">';
                    // echo '<input type="hidden" class="form-control" name="medId[]" id="medId" aria-describedby="basic-addon3" readonly required>';
                    echo '<span class="input-group-text" id="basic-addon3">Medicine Name:</span>';
                    echo '<input type="text" class="form-control" name="medName[]" id="medNames" aria-describedby="basic-addon3" required>';
                    echo '</div>';
                    
                    echo '<div class="input-group mb-4">';
                    echo '<span class="input-group-text" id="basic-addon3">Medicine Price:</span>';
                    echo '<input type="number" class="form-control" name="price[]" id="prices" aria-describedby="basic-addon3" required>';
                    echo '</div>';
                    
                    echo '<div class="input-group mb-4">';
                    echo '<span class="input-group-text" id="basic-addon3">Medicine Quantity:</span>';
                    echo '<input type="number" class="form-control" name="quantity[]" id="quantitys" aria-describedby="basic-addon3" required>';
                    echo '</div>';
                    
                    echo '<div class="input-group mb-4">';
                    echo '<span class="input-group-text" id="basic-addon3">Expiry Date:</span>';
                    echo '<input type="date" class="form-control" name="expD[]" id="expDs" aria-describedby="basic-addon3" required>';
                    echo '</div>';
                    
                    echo '<div class="input-group mb-4">';
                    echo '<span class="input-group-text" id="basic-addon3">Supplier:</span>';
                    echo '<select name="supply[]" id="supplys" class="form-select" aria-label="Default select example">';
                    
                    $sql = "SELECT `sup_Id`, `sup_Company` FROM `supplier`";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['sup_Id'] . "'>". $row['sup_Company'] . "</option>";
                        }
                    }
                    
                    echo '</select>';
                    echo '</div>';
                    ?>
                     <div class="input-group mb-4">
            <label class="input-group-text" for="inputGroupSelect01">Category</label>
            <select  class="form-selects" id="mySelect_1">
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                <?php endforeach; ?>
            </select>
            <input id="selectedInput_1" type="text" name='category[]' aria-label="Last name" class="form-control text-dark" readonly>

        </div>

        <div class="input-group mb-4">
        <span class="input-group-text" id="basic-addon3">Type:</span>
        <select name="medType[]" class="form-select" id="medTypes" aria-label="Default select example">
        <?php foreach ($medicineForms as $form): ?>
            <option value="<?php echo $form; ?>"><?php echo $form; ?></option>
        <?php endforeach; ?>
        </select>
        </div>

                    <?php
                    
                    echo '</div>'; // Closing the 'medicine' div
                ?>
            </div>
            <div class="submitBut">
                <input id="add" name="add" class="add btn-primary" type="button" value="add">

                
                <!-- <input id="clear" name="clear" class="clear btn-outline-dark" type="button" value="clear"> -->
                <input id="cancel" name="cancel" class="cancel btn-primary" type="button" value="Add Form" onclick="addMedicine()">
                <input id="cancel" name="cancel" class="cancel btn-outline-primary" type="button" value="cancel" onclick="closeMedupdate();">

            </div>
        </form>
    </div>
</div>

<div class="overlayMed" id="overlayUp">
    <div class="medForm"> 
        <h1 class="text-white">Medicine Form</h1>
        <br>
        <div id="popup" class="poping" >
    <span id="popupContent"></span>
    <!-- <button id="closePopup">Close</button> -->
</div>
<br> <form id="myForm" >
    <div id="medInputs">
        <div class="medicines">
            <div class="input-group mb-4">
                <input type="hidden" class="form-control" name="medId" id="medId" aria-describedby="basic-addon3" readonly required>
                <input type="hidden" class="form-control" name="action" id="action" aria-describedby="basic-addon3" value = 'update'>
                <input type="hidden" class="form-control" name="medic" id="medic" aria-describedby="basic-addon3" required>

                <span class="input-group-text" id="basic-addon3">Medicine Name:</span>
                <input type="text" class="form-control" name="medName" id="medName" aria-describedby="basic-addon3" required>
            </div>
            <div class="input-group mb-4">
                <span class="input-group-text" id="basic-addon3">Medicine Price:</span>
                <input type="number" class="form-control" name="price" id="price" aria-describedby="basic-addon3" required>
            </div>
            <div class="input-group mb-4">
                <span class="input-group-text" id="basic-addon3">Medicine Quantity:</span>
                <input type="number" class="form-control" name="quantity" id="quantity" aria-describedby="basic-addon3" required>
            </div>
            <div class="input-group mb-4">
                <span class="input-group-text" id="basic-addon3">Expiry Date:</span>
                <input type="date" class="form-control" name="expD" id="expD" aria-describedby="basic-addon3" required>
            </div>
            <div class="input-group mb-4">
                <span class="input-group-text" id="basic-addon3">Supplier:</span>
                <select name="supply"  id="supply" class="form-select" aria-label="Default select example">
                    <?php
                    $sql = "SELECT `sup_Id`, `sup_Company` FROM `supplier`";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['sup_Id'] . "'> ". $row['sup_Company'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="input-group mb-4">
            <label class="input-group-text" for="inputGroupSelect01">Category</label>
            <select  class="form-selects" id="mySelect">
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                <?php endforeach; ?>
            </select>
            <input id="selectedInput" type="text" name='category' aria-label="Last name" class="form-control text-dark" readonly>

        </div>

        <div class="input-group mb-4">
        <span class="input-group-text" id="basic-addon3">Type:</span>
        <select name="medType" id="medType" class="form-select" aria-label="Default select example">
        <?php foreach ($medicineForms as $form): ?>
            <option value="<?php echo $form; ?>"><?php echo $form; ?></option>
        <?php endforeach; ?>
        </select>
        </div>

        </div>
        <div class="submitBut">
            <input id="update" name="updater" class="btn update btn-primary" type="button" value="Update">
            <input id="archive" name="archive" class="btn archive btn-primary" type="button" value="Archive">
           
            <input id="cancel" name="cancel" class="btn cancel btn-primary" type="button" value="Cancel" onclick="closemedUp(); cancelSelection()">
        </div>
    </div>
</form>



                </div>
    </div>
    <div id="overlayer"></div>
    <div id="restockRequestFormContainer" style="display: none;">
    <h2 style="color:white;">Request Restock</h2>
        <form id="restockRequestForm">
        <div class="input-group mb-4">
                <input type="hidden" name="usID" id="usID" value="<?php echo $userID;?>">
                <span class="input-group-text" id="basic-addon3">Medicine:</span>
                <select class="form-control" id="medicine" name="medicine" aria-describedby="basic-addon3" required>
                <?php foreach ($medicines as $meds): ?>
                    <option value="<?= $meds['Med_Id'] ?>"><?= $meds['Med_name'] ?></option>
                <?php endforeach; ?>
                </select>
            </div>
            <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Quantity:</span>
                <input type="number" class="form-control" id="quantity" name="quantity" aria-describedby="basic-addon3" required>
            </div>
            <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Comment:</span>
                <textarea class="form-control" id="comments" name="comments" aria-describedby="basic-addon3" ></textarea>
            </div>
            <br>
            <button type="button" id="submitRequestBtn" class="btn btn-primary">Submit Request</button>
            <button type="button" id="closeFormBtn" class="btn btn-secondary">Close</button>
        </form>
    </div>

    <div class="overlayed" id="replenishOverlay">
    <div class="popup-content">
        <img src="..//image/icons8-close-50.png" alt="close" height="20px" width="20px" class="closed-btn" onclick="closeReplenishPopup()">
        <h2>Replenish Stock</h2>
        <div id="replenishContent"></div>
    </div>
</div>
</div>

<script>

document.getElementById('update').addEventListener('click', function() {
performAction('update');
});

document.getElementById('archive').addEventListener('click', function() {
performAction('archive');
});

$(document).ready(function () {
        // When login button is clicked
        $('#requestRestockBtn').click(function() {
        $('#overlayer').show();
        $('#restockRequestFormContainer').show();
    });

    // Hide the form and overlay when the close button is clicked
    $('#closeFormBtn').click(function() {
        $('#overlayer').hide();
        $('#restockRequestFormContainer').hide();
    });
    $('#submitRequestBtn').click(function() {
        var formData = $('#restockRequestForm').serialize();

        $.ajax({
            type: 'POST',
            url: 'submitRestockRequest.php',
            data: formData,
            success: function(response) {
                alert(response);
                $('#overlay').hide();
                $('#restockRequestFormContainer').hide();
                location.reload();
            },
            error: function(xhr, status, error) {
                alert("Error: " + error);
            }
        });
    });

    });

    function performAction(action) {
    // Get form data
    const formData = new FormData(document.getElementById('myForm'));
    formData.append('action', action);

    $.ajax({
        type: 'POST',
        url: 'manage_code.php', // URL to your login script
        data: formData,
        processData: false, // Prevent jQuery from automatically transforming the data into a query string
        contentType: false, // Set to false to let jQuery automatically set the content type to multipart/form-data
        success: function(response) {
            if (response.trim() === 'Medicine updated successfully.' || response.trim() === 'Archive Success.') {
                // Redirect to dashboard
                alert(response);
                window.location.href = 'mangeStock.php';
            } else {
                document.getElementById('popupContent').innerText = response;
                document.getElementById('popup').style.display = 'block';
            }
        },
        error: function(xhr, status, error) {
            // Handle error
            alert('Error: ' + error); // For demonstration, you can replace this with your error handling logic
        }
    });
}

$(document).ready(function () {
        // When login button is clicked
        $("#add").click(function () {
            // Get form data
            var formData = $("#medicineForm").serialize();

            // Send AJAX request
            $.ajax({
                type: "POST",
                url: "medsInsert.php", // URL to your login script
                data: formData,
                success: function (response) {
                    if (response.trim() === "Medicine added successfully.") {
                        // Redirect to dashboard
                        alert(response);
                        window.location.href = "mangeStock.php";
                    } else {
                        // Alert the error message
                        alert(response);
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error
                    alert("Error: " + error); // For demonstration, you can replace this with your error handling logic
                }
            });
        });
    });

</script>

            </div>


  <script>
    function removeEntry(index) {
    // Get the parent element of the entry to be removed
    var entry = document.getElementsByClassName('medicine')[index];
    
    // Remove the entry from the DOM
    entry.parentNode.removeChild(entry);
}

// function removeAllEntries() {
//         // Get all elements with the class 'medicine'
//         var medicines = document.getElementsByClassName('medicine');
        
//         // Remove each medicine entry
//         while (medicines.length > 0) {
//             medicines[0].parentNode.removeChild(medicines[0]);
//         }
//     }

  </script>

<script src="..//script/manage.js"></script>
<script src="..//script/search.js"></script>

<script>

    var formCount = 1;
function addMedicine() {
    var medicineInputs = document.getElementById('medInputs');
    var newMedicine = document.createElement('div');
    newMedicine.classList.add('medicine');
    formCount++;
    newMedicine.innerHTML = `<br>
    <label>Form :</label>
    <br>
    <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Medicine Name:</span>
            <input type="text" class="form-control" name="medName[]" id="medName_${formCount}" aria-describedby="basic-addon3" required>
        </div>

        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Medicine Price:</span>
            <input type="number" class="form-control" name="price[]" id="price_${formCount}" aria-describedby="basic-addon3"required>
        </div>

        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Medicine Quantity:</span>
            <input type="number" class="form-control" name="quantity[]" id="quantity_${formCount}" aria-describedby="basic-addon3" oninput="statChange()" required>
        </div>   



        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon3">Expiry Date:</span>
            <input type="date" class="form-control" name="expD[]" id="expD_${formCount}" aria-describedby="basic-addon3" required>
        </div>
        
        <div class="input-group mb-4">
                <span class="input-group-text" id="basic-addon3">Supplier:</span>
                <select name='supply[]' id = 'supply_${formCount}' class='form-select' aria-label='Default select example'>
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

                echo "";
            
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['sup_Id'] . "'>". $row['sup_Id'] .' '. $row['sup_Company'] . "</option>";
                }
            
            } else {
                echo "No results found";
                }
            
                $conn->close();
                ?>
                </select>
             </div>
             <div class="input-group mb-4">
                <label class="input-group-text" for="inputGroupSelect01">Options</label>
                <select  class="form-selects" id="mySelect_${formCount}">
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                    <?php endforeach; ?>
                </select>
               
                <input id="selectedInput_${formCount}" name='category[]' type="text" aria-label="Last name" class="form-control text-dark" readonly>
               
            </div>
            
        <div class="input-group mb-4">
        <span class="input-group-text" id="basic-addon3">Type:</span>
        <select name="medType[]" id="medType_${formCount}" class="form-select" aria-label="Default select example">
        <?php foreach ($medicineForms as $form): ?>
            <option value="<?php echo $form; ?>"><?php echo $form; ?></option>
        <?php endforeach; ?>
        </select>
        </div>
    `;
    var removeButton = document.createElement('button');
            removeButton.textContent = 'Remove';
            removeButton.onclick = function() {
                newMedicine.remove();
                formCount--;

            };
    medicineInputs.appendChild(newMedicine);
    newMedicine.appendChild(removeButton);
    initializeSelectHandler(formCount);
}

function initializeSelectHandler(formId) {
        const selectElement = document.getElementById(`mySelect_${formId}`);
        const selectedInput = document.getElementById(`selectedInput_${formId}`);
        const selectedOptionsDiv = document.getElementById(`selectedOptions_${formId}`);

        let selectedOptions = [];

        selectElement.addEventListener('change', function () {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const optionValue = selectedOption.value;

            // Check if the option is already selected
            if (selectedOptions.includes(optionValue)) {
                // Remove the option
                selectedOptions = selectedOptions.filter(value => value !== optionValue);
            } else {
                // Add the option
                selectedOptions.push(optionValue);
            }

            // Update the input field and display div
            selectedInput.value = selectedOptions.join(', ');

            // Update the display div with selected options
            // selectedOptionsDiv.innerHTML = selectedOptions.map(option => `<span>${option}</span>`).join(' ');
        });
    }

    function removeSelected(formId) {
        const selectElement = document.getElementById(`mySelect_${formId}`);
        const selectedOptions = Array.from(selectElement.selectedOptions);
        selectedOptions.forEach(option => {
            option.remove();
        });
    }

    // Initialize the first form
    initializeSelectHandler(1);

function cancels() {
    var medicineInputs = document.getElementById('medInputs');
    // Remove dynamically added forms starting from the second child
    var children = medicineInputs.children;
    for (var i = children.length - 1; i >= 1; i--) {
        medicineInputs.removeChild(children[i]);
    }
    // Reset form count
    formCount = 1;
}
cancel.addEventListener('click',cancels);

function closeButton(){
    document.getElementById('popup').style.display = "none";
    // window.history.back();
    }
    function closet(){
    document.getElementById('popup').style.display = "none";
    window.location.href = 'mangeStock.php';
    }
</script>


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
   

        // Add event listener to the select element

  
</script>  
<script>
    let selectElement = document.getElementById("mySelect");
    let selectedInput = document.getElementById("selectedInput");
    // let selectedOptionsDiv = document.getElementById("selectedOptions");
    let selectedOptions = [];

    selectElement.addEventListener('change', function () {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const optionValue = selectedOption.value;

        if (selectedOptions.includes(optionValue)) {
            selectedOptions = selectedOptions.filter(opt => opt !== optionValue);
        } else {
            selectedOptions.push(optionValue);
        }

        updateSelectedOptions();
        // displaySelectedOptions();
    });

    function updateSelectedOptions() {
        selectedInput.value = selectedOptions.join(', ');
    }

    // function displaySelectedOptions() {
    //     selectedOptionsDiv.innerHTML = '';
    //     selectedOptions.forEach(optionValue => {
    //         let span = document.createElement("span");
    //         span.className = "selected-option";
    //         span.textContent = optionValue;
    //         span.addEventListener("click", function () {
    //             selectedOptions = selectedOptions.filter(opt => opt !== optionValue);
    //             updateSelectedOptions();
    //             displaySelectedOptions();
    //         });
    //         selectedOptionsDiv.appendChild(span);
    //     });
    // }
    $(document).ready(function(){
$(document).on('click', '.restore-btn', function(event) {
   event.preventDefault(); // Prevent default form submission

   var $form = $(this).closest('form');
   var formData = $form.serialize(); // Serialize form data

   $.ajax({
       type: 'POST',
       url: 'manage_code.php',
       data: formData, // Send serialized form data
       success: function(response) {
   if (response) {
   alert('Action performed successfully');
   window.location.href = "mangeStock.php";
   } else {
   alert('Action failed');
   }
       }
   });
});
});
    function cancelSelection() {
        selectedOptions = [];
        updateSelectedOptions();
        // displaySelectedOptions();
    }
  // Fetch the count of medicines with completed orders and update the button

function openReplenish(){
    $.ajax({
        url: 'fetchCompletedOrders.php',
        type: 'GET',
        success: function(response) {
            $('#replenishContent').html(response);
            document.getElementById("replenishOverlay").style.display = 'flex';
        }
    });
}

function closeReplenishPopup() {
    $('#replenishOverlay').hide();
}

// Replenish the stock when the replenish button is clicked
$(document).on('click', '.replenish-btn', function() {
    var medId = $(this).data('medid');
    var orderId = $(this).data('orderid');
    var quantity = $(this).data('quantity');

    $.ajax({
        url: 'manage_code.php',
        type: 'POST',
        data: {
            action: 'replenish',
            medId: medId,
            orderId: orderId,
            quantity: quantity
        },
        success: function(response) {
            if (response.trim() === "Stock replenished successfully.") {
                        // Redirect to dashboard
                        alert(response);
                        location.reload();
                        openReplenishPopup();
                    }else{
                        alert(response);
                    }

        }
    });
});

</script>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</div>
</div>
</body>
</html>


