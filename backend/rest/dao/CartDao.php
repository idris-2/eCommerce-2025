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

    public function getCartByUserId($user_id) {
    $stmt = $this->connection->prepare("
        SELECT c.*, p.name, p.description, p.image_url, p.category, p.price, p.price_old
        FROM cart c
        JOIN orders o ON c.order_id = o.id
        JOIN products p ON c.product_id = p.id
        WHERE o.user_id = :user_id
    ");
    $stmt->bindParam(':user_id', $user_id);
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
