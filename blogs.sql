CREATE DATABASE IF NOT EXISTS database;

USE database;

CREATE TABLE IF NOT EXISTS blogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    author VARCHAR(255) NOT NULL,
    image VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    link VARCHAR(255) NOT NULL
);

INSERT INTO blogs (category, date, author, image, title, link) VALUES
('Investment', '2024-03-14', 'Mark D. Brock', 'img/blog-1.jpg', 'Revisiting Your Investment & Distribution Goals', '#'),
('Business', '2024-03-14', 'Mark D. Brock', 'img/blog-2.jpg', 'Dimensional Fund Advisors Interview with Director', '#'),
('Consulting', '2024-03-14', 'Mark D. Brock', 'img/blog-3.jpg', 'Interested in Giving Back this year? Here are some tips', '#');
