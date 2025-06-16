<?php
require_once('include/db.php');


function selectAllProductsWithCategories(){
    $conn = openDbConnection();
    $product = "
        SELECT 
            product.id, product.title AS product_title, product.description, product.image, product.price,
            c.id AS category_id, c.name AS category_name
        FROM bike_products product
        JOIN bike_categories c ON product.category_id = c.id
        ORDER BY c.name, product.title
    ";
    $result = $conn->query($product);
    
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    return $products;
}


