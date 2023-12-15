# Weather Or Not

SQL Database Script:

CREATE TABLE Users (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;
