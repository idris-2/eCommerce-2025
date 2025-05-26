<?php
require_once __DIR__ . '/../../data/roles.php';
/**
 * @OA\Get(
 *     path="/cart",
 *     summary="Get all cart items",
 *     tags={"cart"},
 *     @OA\Response(
 *         response=200,
 *         description="List of all cart items"
 *     )
 * )
 */
Flight::route('GET /cart', function() {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    echo json_encode(Flight::get('cart_service')->getAll());
});

/**
 * @OA\Get(
 *     path="/cart/{id}",
 *     summary="Get cart item by ID",
 *     tags={"cart"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Cart item ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the cart item with the given ID"
 *     )
 * )
 */
Flight::route('GET /cart/@id', function($id) {
    Flight::auth_middleware()->authorizeRole([Roles::ADMIN, Roles::USER]);
    echo json_encode(Flight::get('cart_service')->getById($id));
});

/**
 * @OA\Post(
 *     path="/cart",
 *     summary="Add item to cart",
 *     tags={"cart"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"order_id", "product_id", "quantity"},
 *             @OA\Property(property="order_id", type="integer", example=2),
 *             @OA\Property(property="product_id", type="integer", example=2),
 *             @OA\Property(property="quantity", type="integer", example=3)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Item added to cart"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input or missing fields"
 *     )
 * )
 */
Flight::route('POST /cart', function() {
    Flight::auth_middleware()->authorizeRole([Roles::ADMIN, Roles::USER]);
    $data = Flight::request()->data->getData();

    // Basic validation
    foreach (['order_id', 'product_id'] as $field) {
        if (!isset($data[$field]) || trim($data[$field]) === '') {
            Flight::halt(400, json_encode(['error' => "$field is required and cannot be null or empty."]));
        }
    }

    if (!isset($data['quantity']) || !is_numeric($data['quantity']) || $data['quantity'] < 0) {
        Flight::halt(400, json_encode(['error' => "Quantity must be a number and cannot be less than 0."]));
    }

    // Fetch product to get price
    $product = Flight::get('product_service')->getById($data['product_id']);
    if (!$product || !isset($product['price']) || $product['price'] <= 0) {
        Flight::halt(400, json_encode(['error' => "Invalid product_id or product price."]));
    }

    // Calculate unit price
    $data['unit_price'] = $data['quantity'] * $product['price'];

    echo json_encode(Flight::get('cart_service')->create($data));
});

/**
 * @OA\Put(
 *     path="/cart/{id}",
 *     summary="Update cart item by ID",
 *     tags={"cart"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Cart item ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="quantity", type="integer", example=2),
 *             @OA\Property(property="order_id", type="integer", example=2),
 *             @OA\Property(property="product_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Cart item updated"
 *     )
 * )
 */
Flight::route('PUT /cart/@id', function($id) {
    Flight::auth_middleware()->authorizeRole([Roles::ADMIN, Roles::USER]);
    $data = Flight::request()->data->getData();
    echo json_encode(Flight::get('cart_service')->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/cart/{id}",
 *     summary="Delete cart item by ID",
 *     tags={"cart"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Cart item ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Cart item deleted"
 *     )
 * )
 */
Flight::route('DELETE /cart/@id', function($id) {
    Flight::auth_middleware()->authorizeRole([Roles::ADMIN, Roles::USER]);
    echo json_encode(Flight::get('cart_service')->delete($id));
});