<?php

include "db.php";

$conn = get_connection();

// Check if ID is set in the URL
if (isset($_GET['id'])) {
    $id = trim($_GET['id']);

    $query = "SELECT * FROM customers WHERE id = {$id}";
    $result = $conn->query($query);
    $bill = $result->fetch_assoc();
}

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
    $total = $units * 5;

    $query = "UPDATE customers SET name = ?, email = ?, unit = ?, total = ? WHERE id = ?";
    $sql = $conn->prepare($query);
    $sql->bind_param("ssidi", $name, $email, $unit, $total, $id);

    try {
        if ($sql->execute()) {
            header("Location: index.php");
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        echo "Error Caused: {$sql->error}";
    }

    $sql->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Bill</title>
</head>

<body>
    <div class="container">
        <h2>Edit Bill</h2>
        <form action="edit_bill.php?id=<?php echo $bill['id'] ?>" method="post">
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
