<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicine_inventory";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$action = $_POST['action'];
$filter = isset($_POST['filter']) ? $_POST['filter'] : 'all';
if($action == 'users'){
$query = "SELECT ua.action, ua.dateTime, ua.Acc_Id, ua.id, acc.Acc_username 
          FROM useraction ua 
          JOIN accounts acc ON ua.Acc_Id = acc.Acc_Id 
          WHERE 1=1 ";

if ($filter == 'today') {
    $query .= "AND DATE(ua.dateTime) = CURDATE() ";
} elseif ($filter == 'month') {
    $query .= "AND MONTH(ua.dateTime) = MONTH(CURDATE()) AND YEAR(ua.dateTime) = YEAR(CURDATE()) ";
} elseif ($filter == 'year') {
    $query .= "AND YEAR(ua.dateTime) = YEAR(CURDATE()) ";
}

$resulti = $conn->query($query);

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

} elseif ($action == 'transaction') {
    $query = "SELECT transactions.trans_id, transactions.archive ,med_inventory.Med_name, med_inventory.Med_price, transactions.trans_quan,
                     transactions.trans_total, accounts.Acc_username, transactions.trans_date 
              FROM transactions
              JOIN med_inventory ON transactions.Med_Id = med_inventory.Med_Id
              JOIN accounts ON transactions.Acc_Id = accounts.Acc_Id
              WHERE 1=1 ";

    if ($filter == 'today') {
        $query .= "AND DATE(transactions.trans_date) = CURDATE() ";
    } elseif ($filter == 'month') {
        $query .= "AND MONTH(transactions.trans_date) = MONTH(CURDATE()) AND YEAR(transactions.trans_date) = YEAR(CURDATE()) ";
    } elseif ($filter == 'year') {
        $query .= "AND YEAR(transactions.trans_date) = YEAR(CURDATE()) ";
    }

    $query .= "AND transactions.archive = 0 ORDER BY transactions.trans_date DESC";

    $resulti = $conn->query($query);

    if ($resulti->num_rows > 0) {
        while ($row = $resulti->fetch_assoc()) {
            echo "<tr class = 'text-center table-dark'  data-user-id = ' ".$row['trans_id']."'>";
            echo "<td>" . $row["Med_name"] . "</td>";
            echo "<td>" . $row["Med_price"] . "</td>";
            // echo "<td>" . $row["Med_ExpDate"] . "</td>";
            echo "<td>" . $row["Acc_username"] . "</td>";
            echo "<td>" . $row["trans_total"] . "</td>";
            echo "<td>" . $row["trans_quan"] . "</td>";
            echo "<td>" . $row["trans_date"] . "</td>";
            echo '<td>       
            <button class="delete btn-danger" style = "border-radius: 8px;" name="delete" id="delete">Archive</button>
            </td>';
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No data found</td></tr>";
    }
}

$conn->close();
?>
