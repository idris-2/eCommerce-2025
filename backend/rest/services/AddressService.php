<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/AddressDao.php';

class AddressService extends BaseService {
    public function __construct() {
        parent::__construct(new AddressDao());
    }

    public function getAddressesByUserId($user_id) {
        return $this->dao->getAddressesByUserId($user_id);
    }
}
