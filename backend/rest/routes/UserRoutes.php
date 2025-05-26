<?php
require_once __DIR__ . '/../../data/roles.php';
/**
 * @OA\Get(
 *     path="/users",
 *     summary="Get all users",
 *     tags={"users"},
 *     @OA\Response(
 *         response=200,
 *         description="List of all users"
 *     )
 * )
 */
Flight::route('GET /users', function() {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    echo json_encode(Flight::get('user_service')->getAll());
});

/**
 * @OA\Get(
 *     path="/users/{id}",
 *     summary="Get a user by ID",
 *     tags={"users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the user",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the user with the given ID"
 *     )
 * )
 */
Flight::route('GET /users/@id', function($id) {
    echo json_encode(Flight::get('user_service')->getById($id));
});

/**
 * @OA\Post(
 *     path="/users",
 *     summary="Create a new user",
 *     tags={"users"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"username", "email", "password"},
 *             @OA\Property(property="username", type="string", example="johndoe"),
 *             @OA\Property(property="email", type="string", example="john@example.com"),
 *             @OA\Property(property="password", type="string", example="securePassword123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User created"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Missing required fields"
 *     )
 * )
 */
Flight::route('POST /users', function() {
    $userData = Flight::request()->data->getData();

    // Validation
    if (!isset($userData['username']) || trim($userData['username']) === '') {
        Flight::halt(400, json_encode(['error' => 'Username is required.']));
    }

    if (!isset($userData['email']) || trim($userData['email']) === '') {
        Flight::halt(400, json_encode(['error' => 'Email is required.']));
    }

    if (!isset($userData['password']) || trim($userData['password']) === '') {
        Flight::halt(400, json_encode(['error' => 'Password is required.']));
    }

    // Hash the password
    $userData['password'] = password_hash($userData['password'], PASSWORD_BCRYPT);

    // Set creation time
    $userData['created_at'] = date('Y-m-d H:i:s');

    echo json_encode(Flight::get('user_service')->create($userData));
});

/**
 * @OA\Put(
 *     path="/users/{id}",
 *     summary="Update user by ID",
 *     tags={"users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the user",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="username", type="string", example="updatedname"),
 *             @OA\Property(property="email", type="string", example="newemail@example.com"),
 *             @OA\Property(property="password", type="string", example="newSecurePassword")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User updated"
 *     )
 * )
 */
Flight::route('PUT /users/@id', function($id) {
    $userData = Flight::request()->data->getData();

    // Optional: Basic validation (you might allow partial updates)
    if (isset($userData['password']) && trim($userData['password']) !== '') {
        $userData['password'] = password_hash($userData['password'], PASSWORD_BCRYPT);
    }

    // Prevent updating created_at
    if (isset($userData['created_at'])) {
        unset($userData['created_at']);
    }

    echo json_encode(Flight::get('user_service')->update($id, $userData));
});

/**
 * @OA\Delete(
 *     path="/users/{id}",
 *     summary="Delete user by ID",
 *     tags={"users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User deleted"
 *     )
 * )
 */
Flight::route('DELETE /users/@id', function($id) {
    echo json_encode(Flight::get('user_service')->delete($id));
});