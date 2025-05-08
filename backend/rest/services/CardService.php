<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/CardDao.php';

class CardService extends BaseService {
    public function __construct() {
        parent::__construct(new CardDao());
    }

    public function getCardsByUserId($user_id) {
        return $this->dao->getCardsByUserId($user_id);
    }
}
