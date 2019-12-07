CREATE DATABASE dbTest;

CREATE TABLE dbTest.Product ( 
    ID INT NOT NULL AUTO_INCREMENT,
    Name VARCHAR(50) NOT NULL,
    Description VARCHAR(100) NULL,
    Price FLOAT NOT NULL,
    CreatedOn TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UpdatedOn TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    IsActive bit(1) NOT NULL DEFAULT b'1',
    PRIMARY KEY (ID)
    );

INSERT INTO dbTest.Product 
    (Name, Description, Price)
VALUES
    ("Apple","An Apple a day keeps the doctor away.",1.89),
    ("Banana","Monkeys love bananas, they are good for humans too",1.78),
    ("Orange","Orange is the only food that shares its name with its color",2.09);