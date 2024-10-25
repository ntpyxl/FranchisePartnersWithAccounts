CREATE TABLE user_accounts (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(32),
    user_password VARCHAR(64)
);

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(32),
    last_name VARCHAR(32),
    age INT,
    gender VARCHAR(32),
    birthdate DATE,
    home_address VARCHAR(512),
    date_registered TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE franchises (
    franchise_id INT AUTO_INCREMENT PRIMARY KEY,
    owner_id INT,
    business_name VARCHAR(64),
    franchise_location VARCHAR(512),
    date_franchised TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE franchise_logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    log_desc VARCHAR(128),
    franchise_id INT,
    owner_id INT,
    done_by INT,
    date_logged TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)