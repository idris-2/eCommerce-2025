<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/OrderDao.php';

class OrderService extends BaseService {
    public function __construct() {
        parent::__construct(new OrderDao());
    }

    public function getOrdersByUserId($user_id) {
        return $this->dao->getOrdersByUserId($user_id);
    }

    public function getOrderById($id) {
        return $this->dao->getOrderById($id);
    }

    public function getOrCreatePendingOrder($user_id) {
        $order = $this->dao->getPendingOrderByUserId($user_id);
        if (!$order) {
            $order_id = $this->dao->insert([
                'user_id' => $user_id,
                'total_price' => 0,
                'order_status' => 'pending',
                'payment_method' => null,
                'shipping_address_id' => null,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $order = $this->dao->getOrderById($order_id);
        }
        return $order;
    }
}
