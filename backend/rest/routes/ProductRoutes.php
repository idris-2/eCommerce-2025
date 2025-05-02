<?php
Flight::route('GET /products', function() {
    echo json_encode(Flight::get('product_service')->getAll());
});

Flight::route('GET /products/@id', function($id) {
    echo json_encode(Flight::get('product_service')->getById($id));
});

Flight::route('POST /products', function() {
    $data = Flight::request()->data->getData();
    echo json_encode(Flight::get('product_service')->createProduct($data));
});

Flight::route('PUT /products/@id', function($id) {
    $data = Flight::request()->data->getData();
    echo json_encode(Flight::get('product_service')->update($id, $data));
});

Flight::route('DELETE /products/@id', function($id) {
    echo json_encode(Flight::get('product_service')->delete($id));
});