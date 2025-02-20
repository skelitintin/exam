<?php
include "db.php"; 

// Check if ID is set in the URL
if (!isset($_GET["id"]) || empty($_GET["id"])) {
    die("Invalid Request. No Bill ID Provided.");
}

$id = $_GET["id"];

// Delete query
$sql = "DELETE FROM billing_records WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

// Redirect to the bills list after deleting
header("Location: view_bills.php");
exit();
?>
