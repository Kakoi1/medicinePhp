<?php 
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "medicine_inventory";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }



  if(isset($_GET['archive'])||isset($_GET['action'])){
    $archive = $_GET['archive'];
    $action = $_GET['action'];

    $sql = "SELECT * FROM categories where archive = $archive";
    $result = $conn->query($sql);
    if($action ==='category'){
  ?>

 <table class="table text-start table-striped table-hover">
        <tr class="table-dark text-start">
            <th>Categories</th>

            <th>Action</th>


           
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr class='text-start'>";
                echo "<td><h4>" . htmlspecialchars($row["name"]) . "</h4>";
                echo "<h5>Description:</h5>";
                echo htmlspecialchars($row["description"]);
                echo "</td>";
                echo "<td>";
                echo "<form>
                <input type='hidden' name='catId' id='catID' value = '".$row["id"]."'>
                <button class='btn btn-primary butoons-btn' data-action='restore' >Restore</button>
                <button class='btn btn-danger butoons-btn' data-action='delete' >Delete</button>
                </form>
                ";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No data found</td></tr>";
        }
  
        ?>
    </table>
    <?php 
  }else if($action ==='medicine'){
    $sql = "SELECT * FROM med_inventory where archive = $archive";
    $result = $conn->query($sql);
  
    ?>
<!-- ================================== -->
<table id="Datatable" class="table table-striped table-hover">
        <tr class="table-dark text-center">
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Expire Date</th>
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
                echo "<td>" . $row["Med_ExpDate"] . "</td>";
                echo "<td>" . $row["category"] . "</td>";
                echo "<td> 
                <div class ='butoon'>
                <form>
                <input type='hidden' name='action' value='restore'>
                <input type='hidden' name='medId' id='medId' value = '".$row["Med_Id"]."'>
                <button class='btn btn-primary restore-btn' >Restore</button>
                </form>
                <form action='addmedicine.php' id = 'deleteForm' method='post'>
                <button type = 'submit' class='delete btn-danger' style = 'border-radius: 8px;' name='delete' id='delete'>Delete</button>
                <input  class='inputSearch' id='dele' name='dele' type='hidden' readonly value = ". $row['Med_Id'].">
                </form>
                </div></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No data found</td></tr>";
        }
        ?>
    </table>
    <?php 
    }else if($action =='supplier'){
        $sql = "SELECT * FROM supplier WHERE archive = $archive";
        $result = $conn->query($sql);
        ?>
        <table class="table table-striped table-hover">
        <tr class="table-dark text-center">
            <th>Supplier Id</th>
            <th>Company</th>
            <th>Address</th>
            <th>Contact No.</th>
            <th>Email</th>
            <th>Action</th>

           
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr class = 'text-center table-dark'>";

                echo "<td>" . $row["sup_Id"] . "</td>";
                echo "<td>" . $row["sup_Company"] . "</td>";
                echo "<td>" . $row["sup_Address"] . "</td>";
                echo "<td>" . $row["sup_Contact_no."] . "</td>";
                echo "<td>" . $row["sup_email"] . "</td>";
                echo "<td> 
                <form id = 'thisForm'>
                <input type='hidden' name='supId' id='supId' value = '".$row["sup_Id"]."'>"
                ?>
                <button class='btn btn-primary restore-btn' onclick ='newAction("restore")' >Restore</button>
                <button type = 'submit' class='btn delete btn-danger' onclick ='newAction("delete")' name='delete' id='delete'>Delete</button>
               <?php
                "
                </form>
               </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No data found</td></tr>";
        }
        ?>
    </table>
    <?php
    }else if($action =='request'){

        $sql = "SELECT rr.id, mi.Med_name, mi.sup_Id, rr.quantity, u.Acc_username, rr.comments, rr.status 
        FROM restock_requests rr 
        JOIN med_inventory mi ON rr.med_id = mi.Med_Id 
        JOIN accounts u ON rr.requester_id = u.Acc_id WHere rr.archive = 1";
        $result = $conn->query($sql); 

        ?>
        <table class="table text-start table-striped table-hover">
        <tr class="table-dark text-start">
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
    <?php
    }else if($action =='order'){

        $sql = "SELECT rr.id, mi.Med_name, mi.sup_Id, rr.quantity, u.Acc_username, rr.comments, rr.status 
        FROM restock_requests rr 
        JOIN med_inventory mi ON rr.med_id = mi.Med_Id 
        JOIN accounts u ON rr.requester_id = u.Acc_id WHere rr.archive = 1";
        $result = $conn->query($sql); 

        ?>
           <table class="table text-start table-striped table-hover">
    <tr class="table-dark text-start">
        <th>Order ID</th>
        <th>Medicine</th>
        <th>Quantity</th>
        <th>Supplier</th>
        <th>Requester</th>
        <th>Order Date</th>
        <th>Estimated Arrival Date</th>
        <th>Status</th>
    </tr>
    <?php
    $sql = "SELECT o.order_id, mi.Med_name, o.quantity, s.sup_Company, u.Acc_username, o.order_date, o.arrival_date, o.status 
            FROM orders o 
            JOIN med_inventory mi ON o.med_id = mi.Med_Id 
            JOIN supplier s ON o.sup_id = s.sup_Id 
            JOIN accounts u ON o.requester_id = u.Acc_id WHERE o.archive = 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
    
    
            echo '<tr class="">';
            echo '<td>' . $row['order_id'] . '</td>';
            echo '<td>' . $row['Med_name'] . '</td>';
            echo '<td>' . $row['quantity'] . '</td>';
            echo '<td>' . $row['sup_Company'] . '</td>';
            echo '<td>' . $row['Acc_username'] . '</td>';
            echo '<td>' . $row['order_date'] . '</td>';
            echo '<td>' . $row['arrival_date'] . '</td>';
            echo '<td>' . $row['status'] . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="9">No orders found</td></tr>';
    }
    ?>
</table>
    <?php
    }
    else if($action =='account'){ 
    
        $sql = "SELECT * FROM accounts Where Acc_status = 'approved'";
        $result = $conn->query($sql);
        
        ?>
     <table class="table table-striped table-hover">
        <tr class="table-dark text-center">
            <th>Username</th>
            <th>Email</th>
            <th>Status</th>
            <th>Action</th>
           
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr class = 'text-center table-dark' data-user-id = ' ".$row['Acc_Id']."'>";

                echo "<td>" . $row["Acc_username"] . "</td>";
                echo "<td>" . $row["Acc_email"] . "</td>";
                echo "<td>" . $row["Acc_status"] . "</td>";
                echo "<td> <div class ='butoon'>  
                <button id = 'reject' class = 'rejBut btn btn-danger'>Deactivate</button>
                </div></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No data found</td></tr>";
        }
        ?>
    </table>
    <?php
    }
    else if($action =='trans'){ 
    
        $sql = "SELECT * FROM accounts Where Acc_status = 'approved'";
        $result = $conn->query($sql);
        
        ?>
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
                t.archive = 1 
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
                <button class="rest btn-primary" style = "border-radius: 8px;" name="delete" id="restore">Restore</button>
                <button class="deleter btn-danger" style = "border-radius: 8px;" name="delete" id="delete">Delete</button>
                </td>';
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No data found</td></tr>";
        }
        ?>
        </tbody>
        </table>
    <?php
    }
}
    ?>