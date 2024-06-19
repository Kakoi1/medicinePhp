<?php
session_start();
$userId = $_SESSION['user_id'] ;
$response = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = mysqli_connect("localhost", "root", "", "medicine_inventory");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $sql = "SELECT SUM(Med_Quantity) AS total_quantity FROM med_inventory ";
    $result = $conn->query($sql);

// Step 3: Get the total quantity
    $totalQuantity = 0;
    if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalQuantity = $row['total_quantity'];
    }

    // Retrieve form data
    $medId = $_POST['medId'] ?? "";
    $medname = $_POST['medName'] ?? "";
    $medic = $_POST['medic'] ?? "";
    $price = $_POST['price'] ?? 0;
    $quantity = $_POST['quantity'] ?? 0;
    $expD = $_POST['expD'] ?? "";
    $supId = $_POST['supply'] ?? "";
    $categ = $_POST['category'] ?? "";
    $action = $_POST['action'] ?? "";
    $type = $_POST['medType'] ?? "";
    $orderId = $_POST['orderId'] ?? "";


    if($action == 'archive'){
        $sql = "UPDATE `med_inventory` SET `archive` = 1 WHERE `Med_Id`= '$medId'";
        if (mysqli_query($conn, $sql)) {
            $sql = "INSERT INTO `useraction`(`action`, `dateTime`, `Acc_Id`) VALUES ('Archive Medicine', current_timestamp(), $userId)";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $response = 'Archive Success.';
        }
    }else if($action === 'restore'){
        $sql = "UPDATE `med_inventory` SET `archive` = 0 WHERE `Med_Id`= '$medId'";
        if (mysqli_query($conn, $sql)) {
            $sql = "INSERT INTO `useraction`(`action`, `dateTime`, `Acc_Id`) VALUES ('Restore Medicine', current_timestamp(), $userId)";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $response = 'Restore Success.';
        }
    }else if($action === 'replenish'){
        $medQuanty =  $quantity + $totalQuantity;

        if($medQuanty >= 1000){
            $response = "Medicine Inventory is Full. Space Available: ". 1000-$totalQuantity;
        }else{
        $sql = "UPDATE med_inventory SET Med_Quantity = Med_Quantity + $quantity WHERE Med_Id = '$medId'";

        if (mysqli_query($conn, $sql)) {

            $sql = "UPDATE orders SET status = 'Replenished' WHERE order_id = '$orderId'";
            mysqli_query($conn, $sql);

            $response = 'Stock replenished successfully.';

            $sql = "INSERT INTO `useraction`(`action`, `dateTime`, `Acc_Id`) VALUES ('Replenish Medicine', current_timestamp(), $userId)";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

        } else {
            $response = 'Error replenishing stock: ' . mysqli_error($conn);
        }
    }
    }
    else{
    // Check if the medicine name is being changed
    if ($medic !== $medname) {
        $sqli = "SELECT * FROM `med_inventory` WHERE `Med_name`='$medname'";
        $result = $conn->query($sqli);

        if ($result->num_rows > 0) {
            $response = 'Medicine name already exists.';
        }
    }

    // Perform validations
    if ($response === '') {

        $medQuanty =  $quantity + $totalQuantity;

        if($medQuanty >= 1000){
            $response = "Medicine Inventory is Full. Space Available: ". 1000-$totalQuantity;
        }

        else if (empty($expD) || strtotime($expD) === false || strtotime($expD) <= time()) {
            $response = 'Invalid expiry date.';
        } else if ($medId == '') {
            $response = 'Select an item first.';
        } else if ($price <= 0) {
            $response = 'Invalid price input.';
        } else if ($quantity <= 0) {
            $response = 'Invalid quantity input.';
        } else {
            // Update database with form data
            $sql = "UPDATE `med_inventory` SET `Med_name` = '$medname', category = '$categ', type = '$type', `Med_price`= $price, `Med_Quantity`= $quantity, `Med_status`= 'Available', `Med_ExpDate`= '$expD', `sup_Id` = '$supId' WHERE `Med_Id`= '$medId'";
            if (mysqli_query($conn, $sql)) {
                $sql = "INSERT INTO `useraction`(`action`, `dateTime`, `Acc_Id`) VALUES ('update Medicine', current_timestamp(), $userId)";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $response = 'Medicine updated successfully.';
            } else {
                $response = 'Some error occurred: ' . $conn->error;
            }
        }
    }

   
}
mysqli_close($conn);
}

echo $response;
?>
