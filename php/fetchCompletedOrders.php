<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicine_inventory";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT o.order_id, mi.Med_name, o.quantity, o.med_id
        FROM orders o
        JOIN med_inventory mi ON o.med_id = mi.Med_Id
        WHERE o.status = 'Completed' AND o.archive = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table class="table table-dark">';
    echo '<thead><tr table-striped text-center><th>Medicine</th><th>Quantity</th><th>Action</th></tr></thead>';
    echo '<tbody>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr text-center>';
        echo '<td>' . $row['Med_name'] . '</td>';
        echo '<td>' . $row['quantity'] . '</td>';
        echo '<td><button class="btn btn-primary replenish-btn" data-orderid="' . $row['order_id'] . '" data-medid="' . $row['med_id'] . '" data-quantity="' . $row['quantity'] . '">Replenish</button></td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
} else {
    echo '<p>No completed orders found</p>';
}

$conn->close();
?>
