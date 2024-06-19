<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicine_inventory";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];

$query = "SELECT DATE(trans_date) as transDate, SUM(trans_total) as totalSales 
          FROM transactions 
          WHERE trans_date BETWEEN '$startDate' AND '$endDate' 
          GROUP BY DATE(trans_date) 
          ORDER BY DATE(trans_date)";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    $data = [];
    $totalSales = 0;
    while ($row = $result->fetch_assoc()) {
        $data['dates'][] = $row['transDate'];
        $data['sales'][] = $row['totalSales'];
        $totalSales += $row['totalSales'];
    }
    $data['totalSales'] = $totalSales; // Include total sales in the response
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'No sales data found for the selected date range']);
}

$conn->close();
?>
