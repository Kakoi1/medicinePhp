<?php
// Establishing connection to the database
$conn = new mysqli("localhost", "root", "", "medicine_inventory");
session_start();
$userId = $_SESSION['user_id'] ;
// Checking for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT SUM(Med_Quantity) AS total_quantity FROM med_inventory ";
$result = $conn->query($sql);

// Step 3: Get the total quantity
$totalQuantity = 0;
if ($result->num_rows > 0) {
$row = $result->fetch_assoc();
$totalQuantity = $row['total_quantity'];
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numMedicines = count($_POST['medName']);

    // Server-side validation errors array
    $submittedData = $_POST;

    $serverErrors = [];
    $submittedMedNames = [];
    $totalMeds = 0;
    $medQuanty = 0;

    for ($i = 0; $i < $numMedicines; $i++) {
        $totalMeds += $_POST['quantity'][$i];
    }

    $medQuanty =  $totalMeds + $totalQuantity;

    if($medQuanty >= 1000){
        $serverErrors[] = "Medicine Inventory is Full. Space Available: ". 1000-$totalQuantity;
    }else{

    for ($i = 0; $i < $numMedicines; $i++) {
        // Checking if all form data for the current medicine is set
        if (isset($_POST['medName'][$i]) && isset($_POST['price'][$i]) && isset($_POST['quantity'][$i]) && isset($_POST['expD'][$i]) && isset($_POST['supply'][$i])&& isset($_POST['category'][$i])&& isset($_POST['medType'][$i])) {
            $medName = $_POST['medName'][$i];
            $price = $_POST['price'][$i];
            $quantity = $_POST['quantity'][$i];
            $expD = $_POST['expD'][$i];
            $supply = $_POST['supply'][$i];
            $category = $_POST['category'][$i];
            $type = $_POST['medType'][$i];
            // Performing server-side validation
            $errors = [];
            $successMessages= [];

            // Validate medicine name
            if (empty($medName)) {
                $errors[] = "Medicine name is required for medicine " . ($i+1);
            }else {
                // Check if the medicine name already exists in the submitted medicine names array
                if (in_array($medName, $submittedMedNames)) {
                    $errors[] = "Medicine name '{$medName}' already exists in another input field.";
                } else {
                    // Add the medicine name to the submitted medicine names array
                    $submittedMedNames[] = $medName;
                }
            }

            // Validate price
            if (!is_numeric($price) || $price <= 0) {
                $errors[] = "Invalid price for medicine " . ($i+1);
            }

            // Validate quantity
            if (!is_numeric($quantity) || $quantity <= 0) {
                $errors[] = "Invalid quantity for medicine " . ($i+1);
            }

            // Validate expiry date
            if (empty($expD) || strtotime($expD) === false || strtotime($expD) <= time()) {
                $errors[] = "Invalid expiry date for medicine " . ($i+1);
            }
            if (empty($category)) {
                $errors[] = "Invalid  Medicine " . ($i+1)." Category";
            }
            if (empty($type)) {
                $errors[] = "Invalid  Medicine " . ($i+1)." Type";
            }

            // If there are validation errors, add them to the serverErrors array
            if (!empty($errors)) {
                $serverErrors = array_merge($serverErrors, $errors);
            }
               // Checking if the medicine name already exists
               $sql_check = "SELECT * FROM `med_inventory` WHERE `Med_name`='$medName'";
               $result_check = $conn->query($sql_check);
               if ($result_check->num_rows > 0) {
                $serverErrors[] = "Medicine '{$medName}' already exists.";
            }
        } else {
            // Handling missing form data
            $serverErrors = "Error: Missing form data for medicine";
        }
    }
}

    // If there are no validation errors, insert medicine data into the database
    if (empty($serverErrors)) {
        for ($i = 0; $i < $numMedicines; $i++) {
            $medName = $_POST['medName'][$i];
            $price = $_POST['price'][$i];
            $quantity = $_POST['quantity'][$i];
            $expD = $_POST['expD'][$i];
            $supply = $_POST['supply'][$i];
            $category = $_POST['category'][$i];
         
                // Inserting data into the database
                $sql_insert = "INSERT INTO med_inventory (`Med_name`, category, type,`Med_price`, `Med_Quantity`, `Med_status`, `Med_ExpDate`, `sup_Id`) 
                            VALUES ('$medName','$category', '$type','$price', '$quantity', 'Available', '$expD', '$supply')";
                if(mysqli_query($conn, $sql_insert)){
                    $successMessages = "Medicine added successfully.";

                } else {
                    $serverErrors[] = "Error inserting '{$medName}': " . mysqli_error($conn);
                }
         
        }
        $submittedData = [];
    }

    // Display any server-side validation errors
    if (!empty($serverErrors)) {

        foreach ($serverErrors as $error) {
            echo $error . '';
        }

    }
    if (!empty($successMessages)) {

        echo $successMessages;
        $sql = "INSERT INTO `useraction`(`action`, `dateTime`, `Acc_Id`) VALUES ('Add Medicine', current_timestamp(), $userId)";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

    }
}



?>