CREATE TABLE IF NOT EXISTS orders_clients (
    id INT AUTO_INCREMENT PRIMARY KEY,            
    customer_id INT NOT NULL,                     
    product VARCHAR(255) NOT NULL,  
    price DECIMAL(10, 2) NOT NULL,                
    quantity INT NOT NULL,                        
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,    
    status VARCHAR(50) NOT NULL,                  
    FOREIGN KEY (customer_id) REFERENCES users(id) 
);
