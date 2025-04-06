<?php
require_once 'UserDao.php';
require_once 'ProductDao.php';
require_once 'CardDao.php';
require_once 'AddressDao.php';
require_once 'OrderDao.php';
require_once 'CartDao.php';

// ========== USERS ==========
echo "=== USERS ===\n";
$userDao = new UserDao();

echo "Get user by ID 2:\n";
print_r($userDao->getUserById(2));

echo "Get user by email 'alice@example.com':\n";
print_r($userDao->getByEmail('alice@example.com'));
/*
echo "Insert new user:\n";
$newUser = [
    'username' => 'Charlie',
    'email' => 'charlie@example.com',
    'password' => 'pass123',
    'created_at' => date('Y-m-d H:i:s')
];
$userDao->insert($newUser);
print_r($userDao->getByEmail('charlie@example.com'));
*/

// ========== PRODUCTS ==========
echo "\n=== PRODUCTS ===\n";
$productDao = new ProductDao();

echo "Get product by ID 1:\n";
print_r($productDao->getProductById(1));

echo "Get products by category 'Keychain':\n";
print_r($productDao->getByCategory('Keychain'));


// ========== CARDS ==========
echo "\n=== CARDS ===\n";
$cardDao = new CardDao();

echo "Get cards for user ID 1:\n";
print_r($cardDao->getCardsByUserId(1));


// ========== ADDRESSES ==========
echo "\n=== ADDRESSES ===\n";
$addressDao = new AddressDao();

echo "Get addresses for user ID 2:\n";
print_r($addressDao->getAddressesByUserId(2));


// ========== ORDERS ==========
echo "\n=== ORDERS ===\n";
$orderDao = new OrderDao();

echo "Get order by ID 1:\n";
print_r($orderDao->getOrderById(1));

echo "Get all orders for user ID 2:\n";
print_r($orderDao->getOrdersByUserId(2));


// ========== CART ==========
echo "\n=== CART ===\n";
$cartDao = new CartDao();

echo "Get cart items for order ID 1:\n";
print_r($cartDao->getItemsByOrderId(1));

echo "Get cart item for order 1, product 2:\n";
print_r($cartDao->getItem(1, 2));

/*
<?php
require_once 'UserDao.php';

$userDao = new UserDao(); // create the object
// Inserting new user
/*
$userDao->insert([
    'username' => 'Idris',
    'email' => 'Idris@example.com',
    'password' => 'secure2'
]);
// 

// Get some User
$users = $userDao->getUserById(2);
print_r($users);
*/