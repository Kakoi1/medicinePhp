<?php 

$conn = new mysqli("localhost", "root", "", "medicine_inventory");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];

if (!empty($startDate) && !empty($endDate)) {
    // Query to get sales within the specified date range
    $query = "SELECT SUM(trans_total) AS weekly_sales FROM transactions WHERE trans_date BETWEEN '$startDate' AND '$endDate'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $weeklySales = $row['weekly_sales'];
        echo "<script>alert('Sales from $startDate to $endDate: $weeklySales units'); window.history.back();</script>";
    } else {
        echo "No sales data for the specified date range.";
    }
} else {
    echo "Please enter both start and end dates.";
}


?>