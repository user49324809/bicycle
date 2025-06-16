<?php
require_once('include/auth_check.php');
require_once('include/db.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);

    $conn = openDbConnection();

    $stmt = $conn->prepare("UPDATE bike_products SET product_title = ?, description = ?, price = ? WHERE id = ?");
    $stmt->bind_param("ssdi", $title, $description, $price, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php");
    exit;
}
?>
