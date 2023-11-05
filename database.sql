USE pzuvo5clr9xvobwh;

-- Create the Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Create the Images Table
CREATE TABLE images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    image_path VARCHAR(255),
    user_id INT,  -- Add a user_id column
    date DATE,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Create the Videos Table
CREATE TABLE videos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    link VARCHAR(255),
    user_id INT,  -- Add a user_id column
    date DATE,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Create the Lesson Plans Table
CREATE TABLE lesson_plans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject VARCHAR(255),
    document_path VARCHAR(255),
    name VARCHAR(255),
    user_id INT,  -- Add a user_id column
    date DATE,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Create the Resources Table
CREATE TABLE resources (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject VARCHAR(255),
    document_path VARCHAR(255),
    user_id INT,  -- Add a user_id column
    name VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
