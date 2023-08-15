<?php
include 'conn.php';
$today = date('Y_m_d');
function tableExists($conn, $tableName) {
    $result = $conn->query("SHOW TABLES LIKE '$tableName'");
    return $result->num_rows > 0;
}

define("P1", 100);
define("P2", 200);
define("P3", 300);
define("P4", 400);
define("P5", 500);



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $product = $_POST['product'];
    $units = $_POST['units'];

    if (isset($units)) {
        if ($product === '2 lit') {
            $price = $units * P1;
            $pricePerUnit = P1;
        }elseif ($product === '200 ml') {
            $price = $units * P2;
            $pricePerUnit = P2;
        }elseif ($product === '300 ml') {
            $price = $units * P3;
            $pricePerUnit = P3;
        }elseif ($product === '500 ml') {
            $price = $units * P4;
            $pricePerUnit = P4;
        }
    }

    // Update the sales table with the provided product and units
    $updateQuery = "UPDATE daily_sales_$today SET prodt_name = '$product', units = '$units', price_per_unit = '$pricePerUnit' , total = '$price' WHERE id = '$id'";
    
    if ($conn->query($updateQuery) === TRUE) {
        echo "Data updated successfully.";
    } else {
        echo "Error updating data: " . $conn->error;
    }
}

$conn->close();
?>
