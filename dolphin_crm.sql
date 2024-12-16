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
-- dummy values for the tables

INSERT INTO Users (firstname, lastname, password, email, role, created_at)
VALUES
('John', 'Doe', 'password123', 'john.doe@example.com', 'admin', NOW()),
('Jane', 'Smith', 'password456', 'jane.smith@example.com', 'user', NOW()),
('Alice', 'son', 'password789', 'alice.son@example.com', 'user', NOW()),
('Bob', 'Boon', 'password000', 'bob.boon@example.com', 'user', NOW());

INSERT INTO Contacts (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by, created_at)
VALUES
('Mr.', 'John', 'Doe', 'john.doe.contact@example.com', '123-456-7890', 'Company A', 'Client', 1, 1, NOW()),
('Ms.', 'Jane', 'Smith', 'jane.smith.contact@example.com', '234-567-8901', 'Company B', 'Lead', 2, 1, NOW()),
('Mr.', 'Alice', 'Johnson', 'alice.johnson.contact@example.com', '345-678-9012', 'Company C', 'Partner', 3, 2, NOW()),
('Ms.', 'Bob', 'Brown', 'bob.brown.contact@example.com', '456-789-0123', 'Company D', 'Client', 4, 3, NOW());

INSERT INTO Notes (contact_id, comment, created_by, created_at)
VALUES
(1, 'Initial meeting scheduled for next week.', 1, NOW()),
(2, 'Follow-up required to close the deal.', 2, NOW()),
(3, 'Discuss partnership details.', 3, NOW()),
(4, 'Waiting for contract approval.', 4, NOW());
