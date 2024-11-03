CREATE TABLE bakery_shop(
    bakeryID INT AUTO_INCREMENT PRIMARY KEY,
    bakeryName VARCHAR (255),
    bakeryAddress VARCHAR (255),
    specialty VARCHAR (255),
    b_license INT,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);

CREATE TABLE product(
    productID INT AUTO_INCREMENT PRIMARY KEY,
    productName VARCHAR (255),
    productType VARCHAR (255),
    price INT,
    p_expiryDate DATE,
    bakeryID INT,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE owner_account(
    ownerID INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(32),
    u_password VARCHAR (128)
);

CREATE TABLE bakery_logs(
    logs_id INT AUTO_INCREMENT PRIMARY KEY,
    logs_description VARCHAR (128),
    bakeryID INT,
    productID INT,
    doneBy INT,
    date_logged TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
