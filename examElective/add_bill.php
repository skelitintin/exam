<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $meter_number = htmlspecialchars($_POST["meter_number"]);
    $address = htmlspecialchars($_POST["address"]);
    $units = htmlspecialchars($_POST["units"]);
    $due_date = htmlspecialchars($_POST["due_date"]);

    // Calculate total amount (₱5 per unit)
    $total_amount = $units * 5;

    $sql = "INSERT INTO billing_records (name, email, meter_number, address, units, total_amount, due_date)
            VALUES (:name, :email, :meter_number, :address, :units, :total_amount, :due_date)"; 
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        "name" => $name,
        "email" => $email,
        "meter_number" => $meter_number,
        "address" => $address,
        "units" => $units,
        "total_amount" => $total_amount,
        "due_date" => $due_date
    ]);

    // Redirect to the view page
    header("Location: view_bills.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Electricity Bill</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #ffffff;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 90%;
            max-width: 600px;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border: 2px solid #28a745;
        }
        h2 {
            margin-bottom: 15px;
            color: #28a745;
        }
        form {
            display: flex;
            flex-direction: column;
            width: 100%;
        }
        label {
            font-weight: bold;
            text-align: left;
            width: 100%;
            margin-top: 10px;
            font-size: 14px;
            color: #212529;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #343a40;
            border-radius: 6px;
            font-size: 16px;
        }
        textarea {
            resize: vertical;
            height: 60px;
        }
        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }
        button, .back-button {
            width: 48%;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        button {
            background: #28a745;
            color: white;
        }
        button:hover {
            background: #218838;
        }
        .back-button {
            background: #343a40;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .back-button:hover {
            background: #23272b;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Add Electricity Bill</h2>
    <form method="post">
        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Meter Number:</label>
        <input type="text" name="meter_number" required>

        <label>Address:</label>
        <textarea name="address" required></textarea>

        <label>Units Consumed:</label>
        <input type="number" name="units" required>

        <label>Due Date:</label>
        <input type="date" name="due_date" required>

        <div class="btn-container">
            <button type="submit">Submit</button>
            <a href="view_bills.php" class="back-button">Back</a>
        </div>
    </form>
</div>

</body>
</html>
