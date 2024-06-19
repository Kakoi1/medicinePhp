<?php 
session_start();
$userId = $_SESSION['user_id'] ;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli("localhost", "root", "", "medicine_inventory");

    // Retrieve form data
    $medId = $_POST['medicine'];
    $quantity = $_POST['quantity'];
    $comments = $_POST['comments'];
    $requesterId = $_POST['usID']; // Assuming the user is logged in and their ID is stored in the session

    // Insert restock request into database
    $stmt = $conn->prepare("INSERT INTO restock_requests (med_id, quantity, requester_id, comments) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $medId, $quantity, $requesterId, $comments);
    if ($stmt->execute()) {

        $sql = "INSERT INTO `useraction`(`action`, `dateTime`, `Acc_Id`) VALUES ('Restock request', current_timestamp(), $userId)";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        echo 'Restock request submitted successfully.';

    } else {
        echo 'Error submitting restock request: ' . $conn->error;
    }

    $stmt->close();
    $conn->close();
}

?>