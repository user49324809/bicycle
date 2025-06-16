CREATE TABLE bike_products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    price DECIMAL(10, 2),
    FOREIGN KEY (category_id) REFERENCES bike_categories(id) ON DELETE CASCADE
);