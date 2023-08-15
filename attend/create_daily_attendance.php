<?php
include 'conn.php'; // Include your database connection

// Get the current date
$currentDate = date('Y-m-d');

// Create a new attendance table for the current date
$tableName = 'attendance_' . $currentDate;
$createTableQuery = "
    CREATE TABLE IF NOT EXISTS `$tableName` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(150) NOT NULL,
        `status` VARCHAR(255) DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";

if ($conn->query($createTableQuery) === TRUE) {
    echo "New attendance table created successfully for $currentDate.";
} else {
    echo "Error creating attendance table: " . $conn->error;
}

// Insert id and name from sales table into the new attendance table
$insertQuery = "
    INSERT INTO `$tableName` (`id`, `name`)
    SELECT `id`, `emp_name` FROM `sales`
";
if ($conn->query($insertQuery) === TRUE) {
    echo "Data inserted into $tableName.";
} else {
    echo "Error inserting data into $tableName: " . $conn->error;
}

$conn->close();
?>
