<?php
require_once __DIR__ . '/../../data/roles.php';
/**
 * @OA\Get(
 *     path="/addresses",
 *     summary="Get all shipping addresses",
 *     tags={"addresses"},
 *     @OA\Response(
 *         response=200,
 *         description="List of all addresses"
 *     )
 * )
 */
Flight::route('GET /addresses', function() {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    echo json_encode(Flight::get('address_service')->getAll());
});

/**
 * @OA\Get(
 *     path="/addresses/{id}",
 *     summary="Get address by ID",
 *     tags={"addresses"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Address ID",
 *         @OA\Schema(type="integer", example=5)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the address with the given ID"
 *     )
 * )
 */
Flight::route('GET /addresses/@id', function($id) {
    Flight::auth_middleware()->authorizeRole([Roles::ADMIN, Roles::USER]);
    echo json_encode(Flight::get('address_service')->getById($id));
});

/**
 * @OA\Post(
 *     path="/addresses",
 *     summary="Create a new shipping address",
 *     tags={"addresses"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"address", "city", "country", "zip_code", "user_id"},
 *             @OA\Property(property="address", type="string", example="123 Main St"),
 *             @OA\Property(property="city", type="string", example="New York"),
 *             @OA\Property(property="country", type="string", example="USA"),
 *             @OA\Property(property="zip_code", type="string", example="10001"),
 *             @OA\Property(property="user_id", type="integer", example=2)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Address successfully created"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Validation error"
 *     )
 * )
 */
Flight::route('POST /addresses', function() {
    Flight::auth_middleware()->authorizeRole([Roles::ADMIN, Roles::USER]);
    $data = Flight::request()->data->getData();

    // Check for required fields (none should be null or missing)
    foreach (['address', 'city', 'country', 'zip_code', 'user_id'] as $field) {
        if (!isset($data[$field]) || trim($data[$field]) === '') {
            Flight::halt(400, json_encode(['error' => "$field is required and cannot be null or empty."]));
        }
    }

    echo json_encode(Flight::get('address_service')->create($data));
});

/**
 * @OA\Put(
 *     path="/addresses/{id}",
 *     summary="Update an existing shipping address",
 *     tags={"addresses"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Address ID",
 *         @OA\Schema(type="integer", example=5)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="address", type="string", example="456 New Ave"),
 *             @OA\Property(property="city", type="string", example="Los Angeles"),
 *             @OA\Property(property="country", type="string", example="USA"),
 *             @OA\Property(property="zip_code", type="string", example="90001"),
 *             @OA\Property(property="user_id", type="integer", example=3)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Address successfully updated"
 *     )
 * )
 */
Flight::route('PUT /addresses/@id', function($id) {
    Flight::auth_middleware()->authorizeRole([Roles::ADMIN, Roles::USER]);
    $data = Flight::request()->data->getData();
    echo json_encode(Flight::get('address_service')->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/addresses/{id}",
 *     summary="Delete address by ID",
 *     tags={"addresses"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Address ID",
 *         @OA\Schema(type="integer", example=5)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Address successfully deleted"
 *     )
 * )
 */
Flight::route('DELETE /addresses/@id', function($id) {
    Flight::auth_middleware()->authorizeRole([Roles::ADMIN, Roles::USER]);
    echo json_encode(Flight::get('address_service')->delete($id));
});