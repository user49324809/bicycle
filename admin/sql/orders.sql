CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(255) NOT NULL,
    product VARCHAR(255) NOT NULL,
    price DECIMAL (10, 2),
    quantity INT,
    date INT NOT NULL,
    status VARCHAR(50) NOT NULL
);


