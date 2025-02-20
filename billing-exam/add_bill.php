<?php

include "db.php";

$conn = get_connection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $meter_number = htmlspecialchars($_POST["meter_number"]);
    $address = htmlspecialchars($_POST["address"]);
    $units = htmlspecialchars($_POST["units"]);
    $due_date = htmlspecialchars($_POST["due_date"]);

    // Calculate total amount (₱5 per unit)
    $total = $units * 5;

    $query = "INSERT INTO bills (name, email, meter_number, address, unit, total, due_date)
    VALUES (?, ?, ?, ?, ?, ?, ?)";

    $sql = $conn->prepare($query);
    $sql->bind_param("ssisids", $name, $email, $meter_number, $address, $unit, $total, $due_date);

    try {
        if ($sql->execute()) {
            header("Location: index.php");
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        echo "Error: {$sql->error}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Electricity Bill</title>
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
