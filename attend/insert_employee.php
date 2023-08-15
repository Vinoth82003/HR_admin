<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you have a database connection established
    include 'conn.php';
    
    $name = $_POST['name'];
    $date = $_POST['date'];

    // Insert into employees table
    $insertQuery = "INSERT INTO employees (emp_name, date,working_days) VALUES ('$name', '$date',0)";
    
    if ($conn->query($insertQuery) === TRUE) {
        echo json_encode(array('status' => 'success', 'message' => 'Employee data inserted successfully'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Error inserting employee data: ' . $conn->error));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request'));
}
?>
