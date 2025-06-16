<?php
require_once('include/auth_check.php');
require_once('include/db.php');

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $conn = openDbConnection();

    // Удаление по ID
    $stmt = $conn->prepare("DELETE FROM bike_products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header('Location: index.php');
exit;


