<?php
include "db.php";

// Check if ID is set in the URL
if (!isset($_GET["id"]) || empty($_GET["id"])) {
    die("Invalid Request. No Bill ID Provided.");
}

$id = $_GET["id"];

// Fetch bill details
$sql = "SELECT * FROM billing_records WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$bill = $stmt->fetch();

if (!$bill) {
    die("Bill Not Found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Bill</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
            background: #ffffff;
            color: #212529;
        }
        .bill-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #28a745;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background: #ffffff;
        }
        h2 {
            margin-bottom: 10px;
            color: #28a745;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        td, th {
            border: 1px solid #28a745;
            padding: 10px;
            text-align: left;
        }
        th {
            background: #28a745;
            color: white;
        }
        .button-container {
            margin-top: 20px;
        }
        .button {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }
        .print-button {
            background: #28a745;
            color: white;
        }
        .print-button:hover {
            background: #218838;
        }
        .back-button {
            background: #343a40;
            color: white;
            margin-left: 10px;
        }
        .back-button:hover {
            background: #23272b;
        }
    </style>
</head>
<body>

<div class="bill-container">
    <h2>Electricity Bill</h2>
    <table>
        <tr><th>Bill ID</th><td><?= htmlspecialchars($bill['id']) ?></td></tr>
        <tr><th>Name</th><td><?= htmlspecialchars($bill['name']) ?></td></tr>
        <tr><th>Email</th><td><?= htmlspecialchars($bill['email']) ?></td></tr>
        <tr><th>Meter Number</th><td><?= htmlspecialchars($bill['meter_number']) ?></td></tr>
        <tr><th>Address</th><td><?= htmlspecialchars($bill['address']) ?></td></tr>
        <tr><th>Units Consumed</th><td><?= htmlspecialchars($bill['units']) ?> kWh</td></tr>
        <tr><th>Total Amount</th><td>₱<?= number_format($bill['total_amount'], 2) ?></td></tr>
        <tr><th>Due Date</th><td><?= htmlspecialchars($bill['due_date']) ?></td></tr>
        <tr><th>Bill Date</th><td><?= htmlspecialchars($bill['bill_date']) ?></td></tr>
    </table>

    <div class="button-container">
        <button class="print-button button" onclick="window.print()">Print Bill</button>
        <button class="back-button button" onclick="window.history.back()">Back</button>
    </div>
</div>

</body>
</html>
