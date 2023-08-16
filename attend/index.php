<?php
include 'conn.php'; // Include your database connection

$today = date('Y_m_d');
$currentDate = date('Y-m-d');
$tableName = 'attendance_' . $currentDate;

// Create attendance table if it doesn't exist
$tableExistsQuery = "SHOW TABLES LIKE '$tableName'";
$tableExistsResult = $conn->query($tableExistsQuery);

if ($tableExistsResult->num_rows === 0) {
    $createTableQuery = "CREATE TABLE IF NOT EXISTS `$tableName` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(150) NOT NULL,
        `status` VARCHAR(255) DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    if ($conn->query($createTableQuery) === TRUE) {
        echo "<script>console.log('New attendance table created successfully for $currentDate');</script>";

        $insertQuery = "INSERT INTO `$tableName` (`id`, `name`)
                        SELECT `id`, `emp_name` FROM `employees`";

        if ($conn->query($insertQuery) === TRUE) {
            echo "<script>console.log('Data inserted into $tableName');</script>";
        } else {
            echo "<script>console.log('Error inserting data into $tableName: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>console.log('Error creating attendance table: " . $conn->error . "');</script>";
    }
} else {
    echo "<script>console.log('Attendance table for $currentDate already exists.');</script>";
}

// Create daily_sales table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS `daily_sales_$today` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `emp_name` VARCHAR(150) NOT NULL,
    `date` DATE NOT NULL,
    `worked_days` INT(11),
    `prodt_name` VARCHAR(200),
    `units` INT(11),
    `price_per_unit` INT(11),
    `total` INT(11)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conn->query($sql) === TRUE) {
    echo "<script>console.log('Table daily_sales_$today created successfully');</script>";

    // Fetch data from yesterday's sales table
    $yesterdaySalesQuery = "SELECT id, emp_name, date, working_days FROM employees ";
    $yesterdaySalesResult = $conn->query($yesterdaySalesQuery);

    if ($yesterdaySalesResult->num_rows > 0) {
        // Check if the first row exists in daily_sales_$today table
        $firstRowExistsQuery = "SELECT id FROM daily_sales_$today LIMIT 1";
        $firstRowExistsResult = $conn->query($firstRowExistsQuery);

        if ($firstRowExistsResult->num_rows === 0) {
            while ($row = $yesterdaySalesResult->fetch_assoc()) {
                $id = $row['id'];
                $empName = $conn->real_escape_string($row['emp_name']);
                $yesterday = $row['date'];
                $workedDays = $row['working_days'];

                // Insert data into daily_sales table
                $insertQuery = "INSERT INTO daily_sales_$today (emp_name, date, worked_days) VALUES ('$empName', '$yesterday', $workedDays)";
                $conn->query($insertQuery);
            }
            echo "<script>console.log('Data inserted into daily_sales_$today table for $yesterday');</script>";
        } else {
            echo "<script>console.log('First row already exists in daily_sales_$today table. Skipping insertion.');</script>";
        }
    } else {
        echo "<script>console.log('No data available for $yesterday');</script>";
    }

} else {
    echo "<script>console.log('Error creating table: " . $conn->error . "');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employees Data</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2>Employees Data</h2>
            <a href="attend.php" class="md3 btn btn-primary">View Attendance</a>
            <button  id="downloadExcel" class="btn btn-warning" style="margin-left:20px">Download Excel</button>

            <table id="salesTable" class=" table table-bordered" style="margin-top: 20px;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Employee Name</th>
                        <th>Date</th>
                        <th>Product Name</th>
                        <th>Units</th>
                        <th>Price per Unit</th>
                        <th>Total</th>
                        <th>Working Days</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $salesQuery = "SELECT * FROM daily_sales_$today";
                    $salesResult = $conn->query($salesQuery);

                    if ($salesResult->num_rows > 0) {
                        while ($row = $salesResult->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["emp_name"] . "</td>";
                            echo "<td>" . $row["date"] . "</td>";
                            if ($row["prodt_name"] === null) {
                                echo "<td> N/A </td>";
                            }else{
                                echo "<td>" . $row["prodt_name"] . "</td>";
                            }
                            if ($row["units"] === null) {
                                echo "<td> N/A </td>";
                            }else{
                                echo "<td>" . $row["units"] . "</td>";
                            }
                            if ($row["price_per_unit"] === null) {
                                echo "<td> N/A </td>";
                            }else{
                                echo "<td>" . $row["price_per_unit"] . "</td>";
                            }
                            if ($row["total"] === null) {
                                echo "<td> N/A </td>";
                            }else{
                                echo "<td>" . $row["total"] . "</td>";
                            }
                            echo "<td>" . $row["worked_days"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No Employees data available.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            
        </div>
    </div>
</div>
<script>
$(document).ready(function () {
    // ... Your existing JavaScript code ...

    // Delete button click event
    $(".delete-btn").click(function () {
        var id = $(this).data("id");

        $.ajax({
            url: "delete_sales.php", // Replace with your PHP script to handle deletion
            method: "POST",
            data: { id: id },
            success: function (response) {
                console.log(response);
                location.reload(); // Reload the page after deletion
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

});
</script>
<script>
document.getElementById("downloadExcel").addEventListener("click", function() {
    const table = document.getElementById("salesTable");
    const ws = XLSX.utils.table_to_sheet(table);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
    const excelBlob = new Blob([XLSX.write(wb, { bookType: "xlsx", type: "binary" })], {
        type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
    });

    const a = document.createElement("a");
    a.href = URL.createObjectURL(excelBlob);
    a.download = "daily_Status_<?php echo $today; ?>.xlsx";
    a.click();
});
</script>



</body>
</html>
<?php
$conn->close();
?>
