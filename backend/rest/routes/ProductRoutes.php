<?php
require_once __DIR__ . '/../../data/roles.php';
// Validate price and name not null or less than 0
function validate_product_data($data) {
    $required_fields = ['name', 'description', 'category', 'price', 'price_old', 'image_url'];

    foreach ($required_fields as $field) {
        if (!isset($data[$field]) || trim($data[$field]) === '') {
            Flight::halt(400, json_encode(["error" => ucfirst($field) . " is required."]));
        }

        if (in_array($field, ['price', 'price_old']) && (!is_numeric($data[$field]) || $data[$field] <= 0)) {
            Flight::halt(400, json_encode(["error" => ucfirst($field) . " must be a numeric value greater than 0."]));
        }
    }
}

/**
 * @OA\Get(
 *     path="/products",
 *     summary="Get all products",
 *     tags={"products"},
 *     @OA\Response(
 *         response=200,
 *         description="List of all products"
 *     )
 * )
 */
Flight::route('GET /products', function() {
    echo json_encode(Flight::get('product_service')->getAll());
});

/**
 * @OA\Get(
 *     path="/products/{id}",
 *     summary="Get product by ID",
 *     tags={"products"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Product ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the product with the given ID"
 *     )
 * )
 */
Flight::route('GET /products/@id', function($id) {
    echo json_encode(Flight::get('product_service')->getById($id));
});

/**
 * @OA\Post(
 *     path="/products",
 *     summary="Create a new product",
 *     tags={"products"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "price", "price_old", "description", "category", "image_url"},
 *             @OA\Property(property="name", type="string", example="Some product"),
 *             @OA\Property(property="price", type="number", format="float", example=19.99),
 *             @OA\Property(property="price_old", type="number", format="float", example=29.99),
 *             @OA\Property(property="description", type="string", example="Very interesting product"),
 *             @OA\Property(property="category", type="string", example="Keychain"),
 *             @OA\Property(property="image_url", type="string", example="https://example.com/images/product.jpg")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product created"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input data"
 *     )
 * )
 */
Flight::route('POST /products', function() {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    validate_product_data($data);
    echo json_encode(Flight::get('product_service')->createProduct($data));
});

/**
 * @OA\Put(
 *     path="/products/{id}",
 *     summary="Update product by ID",
 *     tags={"products"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Product ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Updated Name"),
 *             @OA\Property(property="price", type="number", format="float", example=24.99),
 *             @OA\Property(property="price_old", type="number", format="float", example=34.99)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product updated"
 *     )
 * )
 */
Flight::route('PUT /products/@id', function($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    echo json_encode(Flight::get('product_service')->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/products/{id}",
 *     summary="Delete product by ID",
 *     tags={"products"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Product ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product deleted"
 *     )
 * )
 */
Flight::route('DELETE /products/@id', function($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    echo json_encode(Flight::get('product_service')->delete($id));
});