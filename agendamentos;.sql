CREATE DATABASE agendamentos;
CREATE TABLE agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    arn VARCHAR(255) NOT NULL,
    passport VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);