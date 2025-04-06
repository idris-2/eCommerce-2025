<?php
require_once 'BaseDao.php';

class CartDao extends BaseDao {
    public function __construct() {
        parent::__construct('cart');
    }

    public function getItemsByOrderId($order_id) {
        $stmt = $this->connection->prepare("SELECT * FROM cart WHERE order_id = :order_id");
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getItem($order_id, $product_id) {
        $stmt = $this->connection->prepare("SELECT * FROM cart WHERE order_id = :order_id AND product_id = :product_id");
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        return $stmt->fetch();
    }
}
