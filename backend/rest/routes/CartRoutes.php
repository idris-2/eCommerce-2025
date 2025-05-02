<?php
Flight::route('GET /cart', function() {
    echo json_encode(Flight::get('cart_service')->getAll());
});

Flight::route('GET /cart/@id', function($id) {
    echo json_encode(Flight::get('cart_service')->getById($id));
});

Flight::route('POST /cart', function() {
    $data = Flight::request()->data->getData();
    echo json_encode(Flight::get('cart_service')->create($data));
});

Flight::route('PUT /cart/@id', function($id) {
    $data = Flight::request()->data->getData();
    echo json_encode(Flight::get('cart_service')->update($id, $data));
});

Flight::route('DELETE /cart/@id', function($id) {
    echo json_encode(Flight::get('cart_service')->delete($id));
});