<?php
include "db.php"; 

// Check if ID is set in the URL
if (!isset($_GET["id"]) || empty($_GET["id"])) {
    die("Invalid Request. No Bill ID Provided.");
}

$id = $_GET["id"];

// Fetch the existing record
$sql = "SELECT * FROM billing_records WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$bill = $stmt->fetch(PDO::FETCH_ASSOC);

// If no record found stop execution
if (!$bill) {
    die("Bill record not found!");
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $units = htmlspecialchars($_POST["units"]);

    // Calculate new total amount (₱5 per unit)
    $total_amount = $units * 5;

    // Update query
    $sql = "UPDATE billing_records SET name = ?, email = ?, units = ?, total_amount = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $email, $units, $total_amount, $id]);

    // Redirect back to the bills list
    header("Location: view_bills.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Bill</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            text-align: center;
            padding: 20px;
        }
        .container {
            max-width: 450px;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin: auto;
            border: 2px solid #28a745;
        }
        h2 {
            color: #28a745;
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
            text-align: left;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #28a745;
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            margin-top: 15px;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
        .back-btn {
            display: block;
            margin-top: 15px;
            text-decoration: none;
            color: #007bff;
            font-size: 16px;
        }
        .back-btn:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Bill</h2>
    <form method="post">
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($bill["name"]) ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($bill["email"]) ?>" required>

        <label>Units Consumed:</label>
        <input type="number" name="units" value="<?= htmlspecialchars($bill["units"]) ?>" required>

        <button type="submit">Update Bill</button>
    </form>
    <a href="view_bills.php" class="back-btn">← Back to Bills</a>
</div>

</body>
</html>
