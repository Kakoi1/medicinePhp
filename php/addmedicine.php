<?php
session_start();
$conn = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($conn, "medicine_inventory");
$userId = $_SESSION['user_id'] ;

if(isset($_POST['delete'])) {
    $medId = $_POST['dele'];

    if($medId == '') {
        // Handle case where no medicine ID is provided
        echo "<script>alert('Select an item first.'); window.location.href = 'mangeStock.php'</script>";
    } else {
        try {
            $sql = "DELETE FROM `med_inventory` WHERE `Med_Id`='$medId'";
            if(mysqli_query($conn, $sql)) {
                $sql = "INSERT INTO `useraction`(`action`, `dateTime`, `Acc_Id`) VALUES ('delete Medicine', current_timestamp(), $userId)";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                echo "<script>alert('Medicine deleted successfully.'); window.location.href = 'mangeStock.php'</script>";
            } else {
                // Handle deletion failure
                echo "<script>alert('Failed to delete medicine. Please try again later.'); window.location.href = 'mangeStock.php'</script>";
            }
        } catch (mysqli_sql_exception $e) {
            // Handle exception caused by foreign key constraint violation
            echo "<script>alert('Failed to delete medicine: Foreign key constraint violation.'); window.location.href = 'mangeStock.php'</script>";
        }
    }
}
?>