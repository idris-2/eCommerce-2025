<?php
require_once 'BaseDao.php';

class OrderDao extends BaseDao {
    public function __construct() {
        parent::__construct('orders');
    }

    public function getOrdersByUserId($user_id) {
        $stmt = $this->connection->prepare("SELECT * FROM orders WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getOrderById($id) {
        $stmt = $this->connection->prepare("SELECT * FROM orders WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getPendingOrderByUserId($user_id) {
        $stmt = $this->connection->prepare("SELECT * FROM orders WHERE user_id = :user_id AND order_status = 'pending' LIMIT 1");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetch();
    }
}
