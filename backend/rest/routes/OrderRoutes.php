<?php
require_once __DIR__ . '/../../data/roles.php';
/**
 * @OA\Get(
 *     path="/orders",
 *     summary="Get all orders",
 *     tags={"orders"},
 *     @OA\Response(
 *         response=200,
 *         description="List of all orders"
 *     )
 * )
 */
Flight::route('GET /orders', function() {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    echo json_encode(Flight::get('order_service')->getAll());
});

/**
 * @OA\Get(
 *     path="/orders/{id}",
 *     summary="Get order by ID",
 *     tags={"orders"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Order ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the order with the given ID"
 *     )
 * )
 */
Flight::route('GET /orders/@id', function($id) {
    Flight::auth_middleware()->authorizeRole([Roles::ADMIN, Roles::USER]);
    echo json_encode(Flight::get('order_service')->getById($id));
});

/**
 * @OA\Post(
 *     path="/orders",
 *     summary="Create a new order",
 *     tags={"orders"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id", "total_price", "payment_method", "shipping_address_id"},
 *             @OA\Property(property="user_id", type="integer", example=1),
 *             @OA\Property(property="total_price", type="number", format="float", example=89.99),
 *             @OA\Property(property="payment_method", type="string", example="credit_card"),
 *             @OA\Property(property="shipping_address_id", type="integer", example=2),
 *             @OA\Property(property="order_status", type="string", example="pending")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Order successfully created"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input data"
 *     )
 * )
 */
Flight::route('POST /orders', function() {
    Flight::auth_middleware()->authorizeRole([Roles::ADMIN, Roles::USER]);
    $data = Flight::request()->data->getData();

    // Validate required fields
    $required_fields = ['user_id', 'total_price', 'payment_method', 'shipping_address_id'];
    foreach ($required_fields as $field) {
        if (!isset($data[$field]) || trim($data[$field]) === '') {
            Flight::halt(400, json_encode(['error' => "$field is required and cannot be null or empty."]));
        }
    }

    // Validate total_price
    if (!is_numeric($data['total_price']) || $data['total_price'] <= 0) {
        Flight::halt(400, json_encode(['error' => "total_price must be a number greater than 0."]));
    }

    // Set default order_status if not provided
    if (!isset($data['order_status']) || trim($data['order_status']) === '') {
        $data['order_status'] = 'pending';
    }

    // Set created_at timestamp
    $data['created_at'] = date('Y-m-d H:i:s');

    echo json_encode(Flight::get('order_service')->create($data));
});

/**
 * @OA\Put(
 *     path="/orders/{id}",
 *     summary="Update an existing order by ID",
 *     tags={"orders"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Order ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="user_id", type="integer", example=2),
 *             @OA\Property(property="total_price", type="number", format="float", example=99.99),
 *             @OA\Property(property="payment_method", type="string", example="paypal"),
 *             @OA\Property(property="shipping_address_id", type="integer", example=1),
 *             @OA\Property(property="order_status", type="string", example="shipped")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Order updated"
 *     )
 * )
 */
Flight::route('PUT /orders/@id', function($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();

    // Do not allow changing created_at
    if (isset($data['created_at'])) {
        unset($data['created_at']);
    }

    echo json_encode(Flight::get('order_service')->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/orders/{id}",
 *     summary="Delete order by ID",
 *     tags={"orders"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Order ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Order deleted"
 *     )
 * )
 */
Flight::route('DELETE /orders/@id', function($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    echo json_encode(Flight::get('order_service')->delete($id));
});