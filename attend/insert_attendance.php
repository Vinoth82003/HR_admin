<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you have a database connection established
    include 'conn.php';
    
    $name = $_POST['name'];
    $date = $_POST['date'];

    // Insert into attendance_$today table
    $tableName = 'attendance_' . str_replace('-', '-', $date); // Calculate the table name based on date
    $insertQuery = "INSERT INTO `$tableName` (name, status) VALUES ('$name',null)";
    
    if ($conn->query($insertQuery) === TRUE) {
        echo json_encode(array('status' => 'success', 'message' => 'Data inserted successfully into attendance'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Error inserting data into attendance: ' . $conn->error));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request'));
}
?>
