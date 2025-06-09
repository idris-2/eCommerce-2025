<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/CartDao.php';

class CartService extends BaseService {
    public function __construct() {
        parent::__construct(new CartDao());
    }

    public function getItemsByOrderId($order_id) {
        return $this->dao->getItemsByOrderId($order_id);
    }

    public function getCartByUserId($user_id) {
        return $this->dao->getCartByUserId($user_id);
    }

    public function getItem($order_id, $product_id) {
        return $this->dao->getItem($order_id, $product_id);
    }
}
