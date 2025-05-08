<?php
require_once 'ProductService.php';
require_once 'UserService.php';
require_once 'OrderService.php';
require_once 'CartService.php';
require_once 'CardService.php';
require_once 'AddressService.php';

// ========== USERS ==========
echo "\n=== USERS ===\n";
$user_service = new UserService();
$user = $user_service->getUserById(2);
print_r($user);

$user_by_email = $user_service->getByEmail("alice@example.com");
print_r($user_by_email);

// ========== PRODUCTS ==========
echo "\n=== PRODUCTS ===\n";
$product_service = new ProductService();
$product = $product_service->getProductById(1);
print_r($product);

$products_by_category = $product_service->getByCategory("Keychain");
print_r($products_by_category);

// ========== CARDS ==========
echo "\n=== CARDS ===\n";
$card_service = new CardService();
$cards = $card_service->getCardsByUserId(1);
print_r($cards);

// ========== ADDRESSES ==========
echo "\n=== ADDRESSES ===\n";
$address_service = new AddressService();
$addresses = $address_service->getAddressesByUserId(2);
print_r($addresses);

// ========== ORDERS ==========
echo "\n=== ORDERS ===\n";
$order_service = new OrderService();
$order = $order_service->getOrderById(1);
print_r($order);

$user_orders = $order_service->getOrdersByUserId(2);
print_r($user_orders);

// ========== CART ==========
echo "\n=== CART ===\n";
$cart_service = new CartService();
$cart_items = $cart_service->getItemsByOrderId(1);
print_r($cart_items);

$cart_item = $cart_service->getItem(1, 2);
print_r($cart_item);

// ========== CREATE PRODUCT EXAMPLE ==========
echo "\n=== CREATE PRODUCT ===\n";
try {
    $new_product = $product_service->createProduct([
        "name" => "Mini Panda Keychain",
        "description" => "Cute panda with bell",
        "category" => "Keychain",
        "price" => 7.99,
        "price_old" => 9.99,
        "image_url" => "assets/img/panda.jpg"
    ]);
    echo "Product created successfully.\n";
} catch (Exception $e) {
    echo "Failed to create product: " . $e->getMessage() . "\n";
}
?>
