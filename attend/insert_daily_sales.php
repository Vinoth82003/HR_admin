<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you have a database connection established
    include 'conn.php';
    
    $name = $_POST['name'];
    $date = $_POST['date'];

    // Insert into daily_sales_$today table
    $tableName = 'daily_sales_' . str_replace('-', '_', $date); // Calculate the table name based on date
    $insertQuery = "INSERT INTO `$tableName` (emp_name, date,worked_days) VALUES ('$name', '$date',0)";
    
    if ($conn->query($insertQuery) === TRUE) {
        echo json_encode(array('status' => 'success', 'message' => 'Data inserted successfully into daily sales'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Error inserting data into daily sales: ' . $conn->error));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request'));
}
?>
