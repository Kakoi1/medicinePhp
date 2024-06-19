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
    $userId = $_POST['userId'];
    $action = $_POST['action'];

    if ($action == 'approve') {
        $sql = "UPDATE accounts SET Acc_status='approved' WHERE Acc_id=?";
    } elseif ($action == 'reject') {
        $sql = "UPDATE accounts SET Acc_status='rejected' WHERE Acc_id=?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }

    $stmt->close();
}

$conn->close();
?>
