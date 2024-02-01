<?php
  $conn = mysqli_connect("localhost", "root", "");
  $db = mysqli_select_db($conn, "medicine_inventory");

 

  if(isset($_GET['inputSearch'])){

    $inputed = $_GET['inputSearch'];

    $inputed = mysqli_real_escape_string($conn, $inputed);

    $sql = "SELECT * FROM `med_inventory` WHERE `Med_name`LIKE '%$inputed%'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        
        echo"<table>";

       echo" <tr>
            <th>Med_id</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Expire Date</th>
            <th></th>
        </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr onclick=\"populateForm(" . $row["Med_Id"] . ", '" . $row["Med_name"] . "', " . $row["Med_price"] . ", " . $row["Med_Quantity"] . ",'" . $row["Med_status"] . "','" . $row["Med_ExpDate"] . "')\">";
                echo "<td>" . $row["Med_Id"] . "</td>";
                echo "<td>" . $row["Med_name"] . "</td>";
                echo "<td>" . $row["Med_price"] . "</td>";
                echo "<td>" . $row["Med_Quantity"] . "</td>";
                echo "<td>" . $row["Med_status"] . "</td>";
                echo "<td>" . $row["Med_ExpDate"] . "</td>";
                echo "<td> <div class ='butoon'><button id = 'edit' class = 'editButon' onclick='openMedupdate()'>Edit</button>   
                </div></td>";
                echo "</tr>";
            }
            echo "</table>";

            echo'    <script src="..//script/search.js"></script> "';
  }  else {
    echo "<p>No results found</p>";
}
$result->close();
}
$conn->close();
?>
<script src="..//script/manage.js"></script>