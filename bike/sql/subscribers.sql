use bike_db;
CREATE TABLE subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NULL,
    phone VARCHAR(20) NULL,
    receive_email BOOLEAN DEFAULT TRUE, 
    receive_sms BOOLEAN DEFAULT TRUE,  
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
