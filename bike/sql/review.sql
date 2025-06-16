use bike_db;
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,          
    review_text TEXT NOT NULL,            
    rating INT CHECK (rating BETWEEN 1 AND 5),
    review_date DATE NOT NULL,              
    color_issue BOOLEAN DEFAULT FALSE        
);
