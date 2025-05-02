<?php
Flight::route('GET /users', function() {
    echo json_encode(Flight::get('user_service')->getAll());
});

Flight::route('GET /users/@id', function($id) {
    echo json_encode(Flight::get('user_service')->getById($id));
});

Flight::route('POST /users', function() {
    $data = Flight::request()->data->getData();
    echo json_encode(Flight::get('user_service')->create($data));
});

Flight::route('PUT /users/@id', function($id) {
    $data = Flight::request()->data->getData();
    echo json_encode(Flight::get('user_service')->update($id, $data));
});

Flight::route('DELETE /users/@id', function($id) {
    echo json_encode(Flight::get('user_service')->delete($id));
});