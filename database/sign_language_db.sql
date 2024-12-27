use sign_language_db;

CREATE TABLE detections (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sign VARCHAR(255),
    confidence FLOAT,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
