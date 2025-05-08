<?php
require_once 'BaseDao.php';

class CardDao extends BaseDao {
    public function __construct() {
        parent::__construct('cards');
    }

    public function getCardsByUserId($user_id) {
        $stmt = $this->connection->prepare("SELECT * FROM cards WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
