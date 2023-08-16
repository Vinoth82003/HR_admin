<?php
include 'conn.php'; // Include your database connection

$today =  date('Y_m_d');

header('Content-Type: application/json'); // Set response header to JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Delete query
        $deleteQuery = "DELETE FROM daily_sales_$today WHERE id = $id";

        if ($conn->query($deleteQuery) === TRUE) {
            $response = array('status' => 'success', 'message' => 'Record deleted successfully');
        } else {
            $response = array('status' => 'error', 'message' => 'Error deleting record: ' . $conn->error);
        }

        echo json_encode($response);
    } else {
        $response = array('status' => 'error', 'message' => 'Invalid input');
        echo json_encode($response);
    }
} else {
    $response = array('status' => 'error', 'message' => 'Invalid request');
    echo json_encode($response);
}
?>
