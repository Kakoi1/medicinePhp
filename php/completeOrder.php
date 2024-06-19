<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicine_inventory";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orderId = $_POST['order_id'];
    $action = $_POST['action'];
if($action == 'complete'){
    $sql = "UPDATE orders SET status = 'Completed', archive = 1 WHERE order_id = ?";
    $message ='Order marked as completed successfully.';
}else if($action == 'cancel'){
    $sql = "UPDATE orders SET status = 'Canceled', archive = 1 WHERE order_id = ?";
    $message ='Order marked as Canceled';
}
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $orderId);

    if ($stmt->execute()) {
        echo $message;
    } else {
        echo "Error updating order: " . $conn->error;
    }
}

$conn->close();
?>
