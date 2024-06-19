<?php
$conn = mysqli_connect("localhost", "root", "", "medicine_inventory");
session_start();
$userId = $_SESSION['user_id'] ;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = ['success' => false];
    $catId = $_POST['catId'] ?? null;
    $namer = $_POST['namer'] ?? null;
    $desc = $_POST['desc'] ?? null;
    $action = $_POST['action'] ?? null;

    if ($action === 'add' && $namer && $desc) {
        $stmt = $conn->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $namer, $desc);
        $response['success'] = $stmt->execute();
        $stmt->close();
        $sql = "INSERT INTO `useraction`(`action`, `dateTime`, `Acc_Id`) VALUES ('Add Category', current_timestamp(), $userId)";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->close();
    } elseif ($action === 'update' && $catId && $namer && $desc) {
        $stmt = $conn->prepare("UPDATE categories SET name=?, description=? WHERE id=?");
        $stmt->bind_param("ssi", $namer, $desc, $catId);
        $response['success'] = $stmt->execute();
        $stmt->close();
        $sql = "INSERT INTO `useraction`(`action`, `dateTime`, `Acc_Id`) VALUES ('update Category', current_timestamp(), $userId)";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->close();
    } elseif ($action === 'archive' && $catId) {
        $stmt = $conn->prepare("UPDATE categories SET archive=1 WHERE id=?");
        $stmt->bind_param("i", $catId);
        $response['success'] = $stmt->execute();
        $stmt->close();
        $sql = "INSERT INTO `useraction`(`action`, `dateTime`, `Acc_Id`) VALUES ('archive Category', current_timestamp(), $userId)";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->close();
    } elseif ($action === 'restore' && $catId) {
        $stmt = $conn->prepare("UPDATE categories SET archive=0 WHERE id=?");
        $stmt->bind_param("i", $catId);
        $response['success'] = $stmt->execute();
        $stmt->close();
        $sql = "INSERT INTO `useraction`(`action`, `dateTime`, `Acc_Id`) VALUES ('restore Category', current_timestamp(), $userId)";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->close();
    }  elseif ($action === 'delete' && $catId) {
        $stmt = $conn->prepare("DELETE FROM `categories` WHERE id = ?");
        $stmt->bind_param("i", $catId);
        $response['success'] = $stmt->execute();
        $stmt->close();
        $sql = "INSERT INTO `useraction`(`action`, `dateTime`, `Acc_Id`) VALUES ('delete Category', current_timestamp(), $userId)";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->close();
    }

    echo json_encode($response);
}

$conn->close();
?>
