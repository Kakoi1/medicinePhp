<style>
      /* Add your CSS styles here */
      .selected-row {
         background-color: #c5e1a5; /* Change this to your desired color */
      }
   </style>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<?php
  $conn = mysqli_connect("localhost", "root", "");
  $db = mysqli_select_db($conn, "medicine_inventory");

 

  if (isset($_GET['inputSearch']) || isset($_GET['categories'])) {
   $inputed = isset($_GET['inputSearch']) ? mysqli_real_escape_string($conn, $_GET['inputSearch']) : '';
$categories = isset($_GET['categories']) && is_array($_GET['categories']) ? $_GET['categories'] : [];
$type = isset($_GET['type']) ? mysqli_real_escape_string($conn, $_GET['type']) : '';

$sql = "SELECT  mi.Med_Id, mi.Med_name, mi.type,s.sup_Company, mi.category, mi.Med_price, mi.Med_Quantity, mi.Med_status, mi.Med_ExpDate, mi.sup_Id, mi.archive FROM `med_inventory` mi 
 
            LEFT JOIN supplier s ON mi.sup_Id = s.sup_Id WHERE 1 AND mi.archive = 0 ";

// Append input search condition if provided
if (!empty($inputed)) {
    $sql .= " AND `Med_name` LIKE '%$inputed%'";
}

// Append category condition if provided
if (!empty($categories)) {
    $categoryConditions = array_map(function($category) use ($conn) {
        $category = mysqli_real_escape_string($conn, $category);
        return "`category` LIKE '%$category%'";
    }, $categories);
    $sql .= " AND (" . implode(' OR ', $categoryConditions) . ")";
}

if (!empty($type) && $type !== 'all') {
  $sql .= " AND `type` LIKE '%$type%'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table id='Datatable' class='table table-striped table-hover'>
            <tr class='table-dark text-center'>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Supplier</th>
                <th>Expire Date</th>
                <th>Type</th>
                <th>Category</th>
                <th>Action</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr class='table-dark text-center'>";
        echo "<td>" . $row["Med_name"] . "</td>";
        echo "<td>" . $row["Med_price"] . "</td>";
        echo "<td>" . $row["Med_Quantity"] . "</td>";
        echo "<td>" . $row["Med_status"] . "</td>";
        echo "<td>" . $row["sup_Company"] . "</td>";
        echo "<td>" . $row["Med_ExpDate"] . "</td>";
        echo "<td>" . $row["type"] . "</td>";
        echo "<td>" . $row["category"] . "</td>";
        echo "<td><div class='button'><button id='edit' class='editButton btn btn-primary' onclick=\"populateForm1(" . $row["Med_Id"] . ", '" . $row["Med_name"] . "', " . $row["Med_price"] . ", " . $row["Med_Quantity"] . ",'" . $row["Med_ExpDate"] . "', " . $row["sup_Id"] . ")\">Edit</button></div></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>No results found</p>";
}
$result->close();
}
$conn->close();
?>
<!-- <script src="..//script/manage.js"></script> -->