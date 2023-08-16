<?php
include 'conn.php'; // Include your database connection
// session_start();
function tableExists($conn, $tableName) {
    $result = $conn->query("SHOW TABLES LIKE '$tableName'");
    return $result->num_rows > 0;
}
$response = array(); // Initialize a response array

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Get the current date
    $today = date('Y_m_d'); // Format date as YYYY_MM_DD
    $attend = date('Y-m-d');
    $tableName = 'attendance_'.$attend;

    // Check if the sales table exists for the current date
    if (tableExists($conn, $tableName)) {
        // Update the attendance status in the table
        $updateQuery = "UPDATE `$tableName` SET `status` = '$status' WHERE `id` = $id";

        if ($conn->query($updateQuery) === TRUE) {
            $response['attendance_message'] = "Attendance status updated successfully.";

            if ($status === 'Present') {
                if (tableExists($conn, $tableName)){
                    $updateWorkingDaysQuery = "UPDATE `daily_sales_$today` SET `worked_days` = `worked_days` + 1 WHERE `id` = $id;";
                    
                    
                if ($conn->query($updateWorkingDaysQuery)  === TRUE) {
                    $response['working_days_message'] = "Working days updated successfully.";

                    $employeeWorkingDaysQuery = "UPDATE `employees` SET `working_days` = `working_days` + 1 WHERE `id` = $id;";
                    $conn->query($employeeWorkingDaysQuery);

                } else {
                    $response['working_days_error'] = "Error updating working days: " . $conn->error;
                }
                }
                
            }
        } else {
            $response['attendance_error'] = "Error updating attendance status: " . $conn->error;
        }
    } else {
        $response['table_error'] = "Sales table does not exist for the current date.";
    }
} else {
    $response['invalid_request'] = "Invalid request.";
}

$conn->close();

// $_SERVER['response'] = $response;

// Return the response as JSON
header('Content-Type: application/json');

echo json_encode($response);
?>
