<?php

include "db.php";

$conn = get_connection();

if (isset($_GET['id'])) {
    $id = trim($_GET['id']);

    if (!$id) {
        die("Invalid ID");
    }

    $query = "DELETE FROM customers WHERE id = ?";
    $sql = $conn->prepare($query);
    $sql->bind_param("i", $id);

    try {
        if ($sql->execute()) {
            header("Location: index.php");
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        echo "Error caused by: {$sql->error}";
    }

    $sql->close();
    $conn->close();
}
