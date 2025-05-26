DROP DATABASE IF EXISTS `web2025`;
CREATE DATABASE `web2025`;
USE `web2025`;

-- Table: products
CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  description TEXT,
  category VARCHAR(50),
  price DOUBLE,
  price_old DOUBLE,
  image_url VARCHAR(255)
);

INSERT INTO products VALUES
(1, 'Coffee Crocket Keychain', 'Cute coffee mug with eyes keychain', 'Keychain', 9.99, 12.99, 'assets/img/coffee.jpg'),
(2, 'Robocop Crocket Figurine', 'Mini RoboCop figurine', 'Figurine', 14.99, 19.99, 'assets/img/homepage/img2.png'),
(3, 'Berserk Armor Keychain', 'Metal berserker armor keychain', 'Keychain', 8.50, 10.00, 'assets/img/homepage/img3.png');

-- Table: users (added role)
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50),
  email VARCHAR(100),
  password VARCHAR(255),
  role VARCHAR(20),
  created_at DATETIME
);

INSERT INTO users VALUES
(1, 'alice', 'alice@example.com', '$2y$10$eImiTXuWVxfM37uY4JANjQ==', 'user', '2024-12-01 10:00:00'),
(2, 'bob', 'bob@example.com', '$2y$10$uM61OYTHYuk2WLU7B2lfjOoIE1SzODkCw8qBP96NjXYp05qEPaAHW', 'user', '2025-01-15 14:30:00'),
(3, 'nopen', 'nopen5446@gmail.com', '$2y$10$xp8jwnj0qp4ubGjVRnwraelQEcKmowUofc/p7a66HtqzYAxJZj.rS', 'admin', '2025-05-25 16:11:49');

-- Table: cards
CREATE TABLE cards (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  card_num BIGINT,
  card_name VARCHAR(100),
  expiry_date DATE,
  cvv INT,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO cards VALUES
(1, 1, 4111222233334444, 'Alice Liddell', '2026-05-01', 123),
(2, 2, 4000111122223333, 'Bob Stone', '2027-09-01', 456);

-- Table: addresses
CREATE TABLE addresses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  address VARCHAR(255),
  city VARCHAR(50),
  country VARCHAR(50),
  zip_code VARCHAR(20),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO addresses VALUES
(1, 1, '123 Maple St', 'Wonderland', 'Fictionland', '12345'),
(2, 2, '789 Elm Rd', 'Metroville', 'Imaginaria', '67890');

-- Table: orders
CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  total_price DOUBLE,
  order_status VARCHAR(20),
  payment_method VARCHAR(50),
  shipping_address_id INT,
  created_at DATETIME,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (shipping_address_id) REFERENCES addresses(id)
);

INSERT INTO orders VALUES
(1, 1, 24.98, 'completed', 'card', 1, '2025-04-01 09:00:00'),
(2, 2, 14.99, 'pending', 'paypal', 2, '2025-04-04 16:45:00');

-- Table: cart (acts as order_items)
CREATE TABLE cart (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  product_id INT,
  quantity INT,
  unit_price DOUBLE,
  FOREIGN KEY (order_id) REFERENCES orders(id),
  FOREIGN KEY (product_id) REFERENCES products(id)
);

INSERT INTO cart VALUES
(1, 1, 1, 1, 9.99), -- Alice bought 1x Chibi Knight Keychain
(2, 1, 2, 1, 14.99), -- Alice bought 1x Dragon Figurine
(3, 2, 2, 1, 14.99); -- Bob has 1x Dragon Figurine in cart (order still pending)
