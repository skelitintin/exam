<?php
include "db.php";

// Fetch all records
$sql = "SELECT * FROM billing_records ORDER BY id DESC";
$stmt = $pdo->query($sql);
$bill_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electricity Bills</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            text-align: center;
            padding: 20px;
        }
        .container {
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border: 2px solid #28a745;
        }
        h2 {
            color: #28a745;
            margin-bottom: 15px;
        }
        .add-btn {
            text-decoration: none;
            background: #28a745;
            color: white;
            padding: 10px 15px;
            border-radius: 6px;
            display: inline-block;
            margin-bottom: 15px;
            font-size: 16px;
        }
        .add-btn:hover {
            background: #218838;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #28a745;
            color: white;
        }
        td {
            background: #ffffff;
            color: #212529;
        }
        .btn {
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            color: white;
            border-radius: 5px;
            font-size: 14px;
            display: inline-block;
            text-decoration: none;
        }
        .btn-edit {
            background: #ffc107;
        }
        .btn-delete {
            background: #dc3545;
        }
        .btn-print {
            background: #6c757d;
        }
        .btn:hover {
            opacity: 0.8;
        }
    </style>
    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this bill?")) {
                window.location.href = "delete_bill.php?id=" + id;
            }
        }
    </script>
</head>
<body>

<div class="container">
    <h2>Electricity Bill Records</h2>
    <a class="add-btn" href="add_bill.php">➕ Add New Bill</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Meter Number</th>
                <th>Address</th>
                <th>Units</th>
                <th>Total Amount</th>
                <th>Due Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bill_records as $bill): ?>
            <tr>
                <td><?= $bill["id"] ?></td>
                <td><?= $bill["name"] ?></td>
                <td><?= $bill["meter_number"] ?></td>
                <td><?= $bill["address"] ?></td>
                <td><?= $bill["units"] ?></td>
                <td>₱<?= number_format($bill["total_amount"], 2) ?></td>
                <td><?= $bill["due_date"] ?></td>
                <td>
                    <a href="edit_bill.php?id=<?= $bill["id"] ?>" class="btn btn-edit">✏ Edit</a>
                    <button class="btn btn-delete" onclick="confirmDelete(<?= $bill['id'] ?>)">🗑 Delete</button>
                    <a href="print_bill.php?id=<?= $bill["id"] ?>" class="btn btn-print">🖨 Print</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
