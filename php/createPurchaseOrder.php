<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicine_inventory";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $requestId = $_POST['requestId'];
    $supplierId = $_POST['supplierId'];
    $estimatedArrivalDate = $_POST['estimatedArrivalDate'];

    // Fetch the restock request details
    $sql = "SELECT * FROM restock_requests WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $requestId);
    $stmt->execute();
    $result = $stmt->get_result();
    $request = $result->fetch_assoc();

    if ($request) {
        $medId = $request['med_id'];
        $quantity = $request['quantity'];
        $requesterId = $request['requester_id'];

        // Insert a new order
        $sql = "INSERT INTO orders (med_id, quantity, sup_id, requester_id, arrival_date, status) VALUES (?, ?, ?, ?, ?, 'Pending')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iiiss', $medId, $quantity, $supplierId, $requesterId, $estimatedArrivalDate);

        if ($stmt->execute()) {
            
            $sql = "UPDATE restock_requests SET status='completed', archive = 1 WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $requestId);
            $stmt->execute();

            echo "Order created successfully.";
            
        } else {
            echo "Error creating order: " . $conn->error;
        }
    } else {
        echo "Invalid restock request ID.";
    }
}

$conn->close();
?>
