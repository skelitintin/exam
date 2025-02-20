<?php

include "db.php";

$conn = get_connection();

// Fetch all records
$query = "SELECT * FROM customers";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electricity Bills</title>
</head>

<body>
    <div class="container">
        <h2>Electricity Bill Records</h2>
        <a class="add-btn" href="add_bill.php">➕ Add New Bill</a>
        <?php
        echo "<div class='d-flex justify-content-end m-3'>
          <a href='add_bill.php' class='btn btn-success'>Add Bill</a>
      </div>";

        if ($result->num_rows > 0) {
            echo   "<div class='table-responsive'>
        <table class='table table-striped table-bordered align-middle'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Meter No.</th>
                    <th>Address</th>
                    <th>Units</th>
                    <th>Total Amount</th>
                    <th>Due Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['meter_number']}</td>
                    <td>{$row['address']}</td>
                    <td>{$row['unit']}</td>
                    <td>Php {$row['total']}</td>
                    <td>{$row['due_date']}</td>
                    <td>
                        <a href='update_bill.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                        <a href='delete_bill.php?id={$row['id']}' class='btn btn-danger btn-sm'
                            onclick=\"return confirm('Are you sure you want to delete Meter No. {$row['meter_number']}?')\">Delete</a>
                        <a href='print.php?id={$row['id']}' class='btn btn-secondary btn-sm'>Print</a>
                    </td>
                </tr>";
            }
            echo "</tbody>
        </table>
    </div>";
        } else {
            echo "<p class='text-center text-muted'>No records found.</p>";
        }
        ?>
    </div>

</body>

</html>
