<?php

$products = [
    [
        "id" => 1745260501,
        "image" => "bike_city.jpg",
        "title" => "Велосипед со скоростями",
        "description" => "Горные",
        "price" => 5000,
        "category_id" => 4
    ],
    [
        "id" => 1745260519,
        "image" => "bike_city.jpg",
        "title" => "Велосипед со скоростями",
        "description" => "Горные",
        "price" => 5000,
        "category_id" => 4
    ],
    [
        "id" => 1745260501,
        "image" => "bike_city.jpg",
        "title" => "Велосипед со скоростями",
        "description" => "Горные",
        "price" => 5000,
        "category_id" => 4
    ],
    [
        "id" => 1745260501,
        "image" => "bike_city.jpg",
        "title" => "Велосипед со скоростями",
        "description" => "Горные",
        "price" => 5000,
        "category_id" => 4
    ],
    [
        "id" => 1745260501,
        "image" => "bike_city.jpg",
        "title" => "Велосипед со скоростями",
        "description" => "Горные",
        "price" => 5000,
        "category_id" => 4
    ]
];

// Пример вывода данных
foreach ($products as $product) {
    echo "ID: " . $product['id'] . "<br>";
    echo "Название: " . $product['title'] . "<br>";
    echo "Описание: " . $product['description'] . "<br>";
    echo "Цена: " . $product['price'] . " ₽<br>";
    echo "Категория ID: " . $product['category_id'] . "<br><br>";
}
