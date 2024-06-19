<?php 
$conn = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($conn, "medicine_inventory");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $userId = $_POST['userId'];
  $action = $_POST['action'];

  if ($action == 'archive') {
 
$sql = "UPDATE transactions SET archive = 1 WHERE trans_id = ?";

}else if($action == 'restore'){
  $sql = "UPDATE transactions SET archive = 0 WHERE trans_id = ?";
}else if($action == 'delete'){
  $sql = "DELETE FROM `transactions` WHERE `trans_id`= ?";
}
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
 

if ($stmt->execute()) {
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['success' => false, 'message' => $conn->error]);
}
   
}

?>
