<?php
Flight::route('GET /cards', function() {
    echo json_encode(Flight::get('card_service')->getAll());
});

Flight::route('GET /cards/@id', function($id) {
    echo json_encode(Flight::get('card_service')->getById($id));
});

Flight::route('POST /cards', function() {
    $data = Flight::request()->data->getData();
    echo json_encode(Flight::get('card_service')->create($data));
});

Flight::route('PUT /cards/@id', function($id) {
    $data = Flight::request()->data->getData();
    echo json_encode(Flight::get('card_service')->update($id, $data));
});

Flight::route('DELETE /cards/@id', function($id) {
    echo json_encode(Flight::get('card_service')->delete($id));
});