<?php
$conn = mysqli_connect("localhost", "root", "", "medicine_inventory");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Check if all required POST variables are set and not empty
    if(isset($_POST['usern'], $_POST['email'], $_POST['pass'], $_POST['repass']) && 
       !empty($_POST['usern']) && !empty($_POST['email']) && !empty($_POST['pass']) && !empty($_POST['repass'])) {
        
        $username = $_POST['usern'];
        $email = $_POST['email'];
        $password = $_POST['pass'];
        $repass = $_POST['repass'];
        $salt = "codeflix";
        $hashedPassword = sha1($password . $salt);

        function validateEmail($email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
        }

        if (validateEmail($email)) {
            if ($repass != $password) {
                echo "Password doesn't match. Please try again.";
            } else {
                $result = mysqli_query($conn, "SELECT 1 FROM `accounts` WHERE `Acc_username`= '$username' LIMIT 1");
                if (mysqli_num_rows($result) > 0) {
                    echo "Username already taken.";
                } else {
                    $sql = "INSERT INTO `accounts`(`Acc_username`, `Acc_password`, `Acc_email`, `Acc_date`, `Acc_time`) VALUES ('$username','$hashedPassword','$email', CURDATE(), CURTIME())";
                    if (mysqli_query($conn, $sql)) {
                        echo "User registered successfully.";
                    } else {
                        echo "Error: " . mysqli_error($conn);
                    }
                }
            }
        } else {
            echo "Invalid email.";
        }
    } else {
        echo "All fields are required.";
    }

    mysqli_close($conn);
}
?>
