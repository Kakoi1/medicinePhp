<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if username and password are set and not empty
    if (isset($_POST["users"], $_POST["passw"]) && !empty($_POST["users"]) && !empty($_POST["passw"])) {
        $conn = mysqli_connect("localhost", "root", "", "medicine_inventory");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $uname = $_POST["users"];
        $pass = $_POST["passw"];

        $salt = "codeflix";
        $hashedPassword = sha1($pass . $salt);

        $sql = "SELECT * FROM accounts WHERE Acc_username = ? AND Acc_password = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ss", $uname, $hashedPassword);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $_SESSION['user_id'] = $row['Acc_Id'];
            $_SESSION['user_name'] = $row['Acc_username'];
            setcookie('user', $row['Acc_username'], time() + 24 * 3600, '/');

     if($row['Acc_status'] == 'approved'){
        echo 'Login successful!';
     }else if($row['Acc_status'] == 'pending'){
        echo 'Account is Still pending for approval';
     }else if($row['Acc_status'] == 'rejected'){
        echo 'Account is Rejected';
     }else if($row['Acc_status'] == 'admin'){
        echo 'Admin Login successful!';

     }


        exit();
        } else {
            echo "Incorrect username or password. Please try again.";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Username and password are required.";
    }
}
?>
