CREATE TABLE bike_products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    price DECIMAL(10, 2),
    discount_for_registered DECIMAL(5, 2) DEFAULT 0,  
    price_with_discount DECIMAL(10, 2) DEFAULT 0, 
    FOREIGN KEY (category_id) REFERENCES bike_categories(id) ON DELETE CASCADE
);

