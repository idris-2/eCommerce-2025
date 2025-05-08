<?php
require_once 'BaseDao.php';

class AddressDao extends BaseDao {
    public function __construct() {
        parent::__construct('addresses');
    }

    public function getAddressesByUserId($user_id) {
        $stmt = $this->connection->prepare("SELECT * FROM addresses WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
