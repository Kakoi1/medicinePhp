<?php
$conn = mysqli_connect("localhost", "root", "", "medicine_inventory");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $action = $_POST['action'];

    if ($action == 'approve') {
        $sql = "UPDATE restock_requests SET status='approved' WHERE id=?";
    } else if ($action == 'reject') {
        $sql = "UPDATE restock_requests SET status='rejected', archive = 1 WHERE id=?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Request " . ucfirst($action) . "d successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
