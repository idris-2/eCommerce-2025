<?php
require_once __DIR__ . '/vendor/autoload.php';

// SERVICES
require_once __DIR__ . '/rest/services/UserService.php';
require_once __DIR__ . '/rest/services/ProductService.php';
require_once __DIR__ . '/rest/services/OrderService.php';
require_once __DIR__ . '/rest/services/CartService.php';
require_once __DIR__ . '/rest/services/AddressService.php';
require_once __DIR__ . '/rest/services/CardService.php';

// REGISTER SERVICES
// Flight::register('userService', 'UserService');
// Flight::register('productService', 'ProductService');
// Flight::register('orderService', 'OrderService');
// Flight::register('cartService', 'CartService');
// Flight::register('addressService', 'AddressService');
// Flight::register('cardService', 'CardService');

Flight::set('user_service', new UserService());
Flight::set('address_service', new AddressService());
Flight::set('card_service', new CardService());
Flight::set('cart_service', new CartService());
Flight::set('order_service', new OrderService());
Flight::set('product_service', new ProductService());

header('Content-Type: application/json');

// ROUTES
require_once __DIR__ . '/rest/routes/UserRoutes.php';
require_once __DIR__ . '/rest/routes/ProductRoutes.php';
require_once __DIR__ . '/rest/routes/OrderRoutes.php';
require_once __DIR__ . '/rest/routes/CartRoutes.php';
require_once __DIR__ . '/rest/routes/AddressRoutes.php';
require_once __DIR__ . '/rest/routes/CardRoutes.php';

Flight::route('/', function () {
    echo "Hello, FlightPHP!";
});

// START
Flight::start();
