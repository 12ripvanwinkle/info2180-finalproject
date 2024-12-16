

CREATE TABLE IF NOT EXISTS Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    role VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS Contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telephone VARCHAR(255) NOT NULL,
    company VARCHAR(255) NOT NULL,
    type VARCHAR(255) NOT NULL,
    assigned_to INT NOT NULL,
    created_by INT NOT NULL,
    created_at DATETIME DEFAULT NOW(),
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS Notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contact_id INT NOT NULL,
    comment TEXT,
    created_by INT NOT NULL,
    created_at DATETIME DEFAULT NOW(),
    FOREIGN KEY (contact_id) REFERENCES Contacts(id)
);

INSERT INTO Users (firstname, lastname, password, email, role)
VALUES ("Mohammed", "Salah", "$2y$10$gW/tclXlJgGKzl0/wKhXwuSbvSSogfKyZlqgemrfz42O1Wtenfn5G", "admin@project2.com", "Admin");