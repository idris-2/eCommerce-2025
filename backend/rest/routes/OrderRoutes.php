<?php
Flight::route('GET /orders', function() {
    echo json_encode(Flight::get('order_service')->getAll());
});

Flight::route('GET /orders/@id', function($id) {
    echo json_encode(Flight::get('order_service')->getById($id));
});

Flight::route('POST /orders', function() {
    $data = Flight::request()->data->getData();
    echo json_encode(Flight::get('order_service')->create($data));
});

Flight::route('PUT /orders/@id', function($id) {
    $data = Flight::request()->data->getData();
    echo json_encode(Flight::get('order_service')->update($id, $data));
});

Flight::route('DELETE /orders/@id', function($id) {
    echo json_encode(Flight::get('order_service')->delete($id));
});