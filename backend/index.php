<?php
require_once __DIR__ . '/vendor/autoload.php';

// SERVICES
require_once __DIR__ . '/rest/services/UserService.php';
require_once __DIR__ . '/rest/services/ProductService.php';
require_once __DIR__ . '/rest/services/OrderService.php';
require_once __DIR__ . '/rest/services/CartService.php';
require_once __DIR__ . '/rest/services/AddressService.php';
require_once __DIR__ . '/rest/services/CardService.php';

require_once __DIR__ . '/rest/services/AuthService.php';
require_once __DIR__ . '/middleware/AuthMiddleware.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

Flight::register('auth_service', "AuthService");
Flight::register('auth_middleware', "AuthMiddleware");

// This wildcard route intercepts all requests and applies authentication checks before proceeding.
Flight::route('/*', function() {
    error_log("Headers: " . json_encode(getallheaders()));
   if(
       strpos(Flight::request()->url, '/auth/login') === 0 ||
       strpos(Flight::request()->url, '/auth/register') === 0 ||
       strpos(Flight::request()->url, '/docs') === 0
   ) {
       return TRUE;
   } else {
       try {
           $token = Flight::request()->getHeader("Authentication");
           if ($token && strpos($token, 'Bearer ') === 0) {
               $token = substr($token, 7); // Remove "Bearer " prefix
           }
           if(Flight::auth_middleware()->verifyToken($token))
               return TRUE;
       } catch (\Exception $e) {
           Flight::halt(401, $e->getMessage());
       }
   }
});


header('Content-Type: application/json');

// ROUTES
require_once __DIR__ . '/rest/routes/UserRoutes.php';
require_once __DIR__ . '/rest/routes/ProductRoutes.php';
require_once __DIR__ . '/rest/routes/OrderRoutes.php';
require_once __DIR__ . '/rest/routes/CartRoutes.php';
require_once __DIR__ . '/rest/routes/AddressRoutes.php';
require_once __DIR__ . '/rest/routes/CardRoutes.php';

require_once __DIR__ . '/rest/routes/AuthRoutes.php';

Flight::route('/', function () {
    echo "Hello, FlightPHP!";
});

// START
Flight::start();
