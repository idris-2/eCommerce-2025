<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/ProductDao.php';

class ProductService extends BaseService {
    public function __construct() {
        parent::__construct(new ProductDao());
    }

    public function getByCategory($category) {
        return $this->dao->getByCategory($category);
    }

    public function getProductById($id) {
        return $this->dao->getProductById($id);
    }

    public function createProduct($data) {
        if ($data['price'] <= 0) {
            throw new Exception("Price must be positive");
        }
        return $this->create($data);
    }
}
