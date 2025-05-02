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
}
