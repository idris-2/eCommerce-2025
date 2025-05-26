<?php
require_once __DIR__ . '/../../data/roles.php';
// Null check for POST (all required)
function validate_card_required_fields($data) {
    $required_fields = ['user_id', 'card_num', 'card_name', 'expiry_date', 'cvv'];

    foreach ($required_fields as $field) {
        if (!isset($data[$field]) || trim($data[$field]) === '') {
            Flight::halt(400, json_encode(["error" => "$field is required."]));
        }
    }
}

// Format expiry_date if present (for both POST and PUT)
function format_expiry_date_if_needed(&$data) {
    if (!isset($data['expiry_date'])) return;

    $date = $data['expiry_date'];

    // If it's in format like "04/27" or "27/04"
    if (preg_match('/^\d{2}\/\d{2}$/', $date)) {
        $parts = explode('/', $date);

        $first = intval($parts[0]);
        $second = intval($parts[1]);

        if ($first > 12) {
            $month = $second;
            $year = $first;
        } else {
            $month = $first;
            $year = $second;
        }

        $year += ($year < 100) ? 2000 : 0;

        if ($month < 1 || $month > 12) {
            Flight::halt(400, json_encode(["error" => "Invalid expiry_date month."]));
        }

        $data['expiry_date'] = sprintf('%04d-%02d-01', $year, $month);
    }

    // Validate final format
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['expiry_date'])) {
        Flight::halt(400, json_encode(["error" => "expiry_date must be in format YYYY-MM-DD."]));
    }
}

/**
 * @OA\Get(
 *     path="/cards",
 *     summary="Get all saved cards",
 *     tags={"cards"},
 *     @OA\Response(
 *         response=200,
 *         description="List of all cards"
 *     )
 * )
 */
Flight::route('GET /cards', function() {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    echo json_encode(Flight::get('card_service')->getAll());
});

/**
 * @OA\Get(
 *     path="/cards/{id}",
 *     summary="Get card by ID",
 *     tags={"cards"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Card ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the card with the given ID"
 *     )
 * )
 */
Flight::route('GET /cards/@id', function($id) {
    Flight::auth_middleware()->authorizeRole([Roles::ADMIN, Roles::USER]);
    echo json_encode(Flight::get('card_service')->getById($id));
});

/**
 * @OA\Post(
 *     path="/cards",
 *     summary="Add a new card",
 *     tags={"cards"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id", "card_num", "card_name", "expiry_date", "cvv"},
 *             @OA\Property(property="user_id", type="integer", example=2),
 *             @OA\Property(property="card_num", type="string", example="4111111111111111"),
 *             @OA\Property(property="card_name", type="string", example="John Doe"),
 *             @OA\Property(property="expiry_date", type="string", example="25/04"),
 *             @OA\Property(property="cvv", type="string", example="123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Card successfully created"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Validation error"
 *     )
 * )
 */
Flight::route('POST /cards', function() {
    Flight::auth_middleware()->authorizeRole([Roles::ADMIN, Roles::USER]);
    $data = Flight::request()->data->getData();
    validate_card_required_fields($data);
    format_expiry_date_if_needed($data);
    echo json_encode(Flight::get('card_service')->create($data));
});

/**
 * @OA\Put(
 *     path="/cards/{id}",
 *     summary="Update an existing card",
 *     tags={"cards"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Card ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="card_num", type="string", example="4111111111111111"),
 *             @OA\Property(property="card_name", type="string", example="John Doe"),
 *             @OA\Property(property="expiry_date", type="string", example="26/05"),
 *             @OA\Property(property="cvv", type="string", example="456")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Card successfully updated"
 *     )
 * )
 */
Flight::route('PUT /cards/@id', function($id) {
    Flight::auth_middleware()->authorizeRole([Roles::ADMIN, Roles::USER]);
    $data = Flight::request()->data->getData();
    format_expiry_date_if_needed($data);  // Only run if expiry_date is being updated
    echo json_encode(Flight::get('card_service')->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/cards/{id}",
 *     summary="Delete a card by ID",
 *     tags={"cards"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Card ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Card successfully deleted"
 *     )
 * )
 */
Flight::route('DELETE /cards/@id', function($id) {
    Flight::auth_middleware()->authorizeRole([Roles::ADMIN, Roles::USER]);
    echo json_encode(Flight::get('card_service')->delete($id));
});