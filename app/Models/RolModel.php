<?php

namespace Com\Daw2\Models;

use \PDO;

class RolModel extends \Com\Daw2\Core\BaseDbModel {
    
    const SELECT_FROM = "SELECT * FROM aux_rol";

    function getRolls(): array {
        $stmt = $this->pdo->query(self::SELECT_FROM . " ORDER BY nombre_rol");
        $roles = $stmt->fetchAll();
        return $roles;
    }
    
}
