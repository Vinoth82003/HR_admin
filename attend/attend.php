<!DOCTYPE html>
<html>
<head>
    <title>Attendance Data</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
include 'conn.php';
// session_start();

// print_r( $_SERVER['response'] );
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2>Attendance Data</h2>
             <a href="index.php" class="md3 btn btn-primary">View Employees</a>
             <button class="btn btn-primary" id="addEmployeeBtn" style="margin-left: 20px;">Add Employee</button>

             <div class="modal fade" id="employeeModal" tabindex="-1" role="dialog" aria-labelledby="employeeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="employeeModalLabel">Add Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Employee Form -->
                <form id="addEmployeeForm">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveEmployeeBtn">Save</button>
            </div>
        </div>
    </div>
</div>
             
            <table class=" table table-bordered" style="margin-top: 20px;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Product Name</th>
                        <th>Units</th>
                        <th>Attendance</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    // Get the date from the URL parameter
                    $currentDate = isset($_GET['date']) ? $_GET['date'] : date('Y_m_d');
                    $tableName = 'attendance_' . str_replace('_', '-', $currentDate); // Replace dashes with underscores

                    // Query to fetch attendance data for the specified date
                    $attendanceQuery = "SELECT A.id, A.name, A.status, S.prodt_name, S.units FROM `$tableName` A LEFT JOIN daily_sales_$currentDate S ON A.id = S.id"; // Use backticks for table names
                    $attendanceResult = $conn->query($attendanceQuery);

                    if ($attendanceResult->num_rows > 0) {
                        while ($row = $attendanceResult->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row["id"] . '</td>';
                            echo '<td>' . $row["name"] . '</td>';
                            echo '<td>';
                            echo '<select disabled class="form-control product-select" data-id="' . $row['id'] . '">';
                            echo '<option value="">Select Product</option>';
                            echo '<option value="2 lit">2 Lit</option>';
                            echo '<option value="200 ml">200ml</option>';
                            echo '<option value="300 ml">300ml</option>';
                            echo '<option value="500 ml">500ml</option>';
                            echo '</select>';
                            echo '</td>';
                            echo '<td>';
                            echo '<input disabled type="number" class="form-control units-input" data-id="' . $row['id'] . '">';
                            echo '</td>';
                            // Rest of the table data
                            echo '<td>';
                            if ($row["status"] == 'Present') {
                                echo '<span class="badge badge-success">Present</span>';
                            } elseif ($row["status"] == 'Absent') {
                                echo '<span class="badge badge-danger">Absent</span>';
                            } else {
                                echo '<span class="badge badge-secondary">N/A</span>';
                            }
                            echo '</td>';
                            echo '<td class="status">' . $row["status"] . '</td>';
                            echo '<td class="attendBtns">';
                            if (!$row["status"]) {
                                echo '<button class="btn btn-primary present-btn" data-id="' . $row["id"] . '"><i class="fas fa-check "></i> Present</button>';
                                echo '<button class="btn btn-warning absent-btn" data-id="' . $row["id"] . '"><i class="fas fa-times text-danger"></i> Absent</button>';
                            } else {
                                echo 'N/A';
                            }
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="7">No attendance data available for ' . $currentDate . '.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
            
        </div>
    </div>
</div>

<!-- JavaScript section -->
<script src="script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
$(document).ready(function () {
    $(".product-select, .units-input").change(function () {
        var id = $(this).data("id");
        var product = $(".product-select[data-id='" + id + "']").val();
        var units = $(".units-input[data-id='" + id + "']").val();

        $.ajax({
            url: "update_sales.php", // Replace 
            method: "POST",
            data: { id: id, product: product, units: units },
            success: function () {
                console.log("Data updated for ID " + id);
            }
        });
    });

    $(".present-btn, .absent-btn").click(function () {
        var id = $(this).data("id");
        var status = $(this).hasClass("present-btn") ? "Present" : "Absent";

        $.ajax({
            url: "update_attendance.php", // Replace 
            method: "POST",
            data: { id: id, status: status },
            success: function (response) {
                console.log(response);
                $(".present-btn[data-id='" + id + "'], .absent-btn[data-id='" + id + "']").prop("disabled", true);
                location.reload();
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

});



</script>
<!-- ... Your existing HTML and JavaScript ... -->

<script>
$(document).ready(function () {
    $("#addEmployeeBtn").click(function () {
        $("#employeeModal").modal("show");
    });

    $("#saveEmployeeBtn").click(function () {
        var name = $("#name").val();
        var currentDate = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format

        // Insert into employees table
        $.ajax({
            url: "insert_employee.php",
            method: "POST",
            data: { name: name, date: currentDate }, // Include the date
            success: function (response) {
                console.log(response);
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });

        // Insert into daily_sales_$today table
        $.ajax({
            url: "insert_daily_sales.php", // Replace with your PHP script for inserting into daily_sales_$today
            method: "POST",
            data: { name: name, date: currentDate }, // Include the necessary data
            success: function (response) {
                console.log(response);
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });

        // Insert into attendance_$today table
        $.ajax({
            url: "insert_attendance.php", // Replace with your PHP script for inserting into attendance_$today
            method: "POST",
            data: { name: name, date: currentDate }, // Include the necessary data
            success: function (response) {
                console.log(response);
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
        location.reload();
        // Close the modal
        $("#employeeModal").modal("hide");
        
    });
});
</script>
</body>
</html>