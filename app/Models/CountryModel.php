<?php

namespace Com\Daw2\Models;

use \PDO;

class CountryModel extends \Com\Daw2\Core\BaseDbModel {
    
    const SELECT_FROM = "SELECT * FROM aux_countries";

    function getCountries(): array {
        $stmt = $this->pdo->query(self::SELECT_FROM . " ORDER BY country_name");
        $countries = $stmt->fetchAll();
        return $countries;
    }
    
}
