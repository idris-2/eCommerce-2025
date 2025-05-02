<?php
Flight::route('GET /addresses', function() {
    echo json_encode(Flight::get('address_service')->getAll());
});

Flight::route('GET /addresses/@id', function($id) {
    echo json_encode(Flight::get('address_service')->getById($id));
});

Flight::route('POST /addresses', function() {
    $data = Flight::request()->data->getData();
    echo json_encode(Flight::get('address_service')->create($data));
});

Flight::route('PUT /addresses/@id', function($id) {
    $data = Flight::request()->data->getData();
    echo json_encode(Flight::get('address_service')->update($id, $data));
});

Flight::route('DELETE /addresses/@id', function($id) {
    echo json_encode(Flight::get('address_service')->delete($id));
});