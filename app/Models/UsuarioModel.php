<?php

namespace Com\Daw2\Models;

use \PDO;

class UsuarioModel extends \Com\Daw2\Core\BaseDbModel {

    const SELECT_FROM = "SELECT u.*, ar.nombre_rol as rol, ac.country_name FROM usuario u LEFT JOIN aux_rol ar ON ar.id_rol = u.id_rol LEFT JOIN aux_countries ac ON u.id_country = ac.id";
    const SELECT_COUNT = "SELECT COUNT(*) as total FROM usuario u LEFT JOIN aux_rol ar ON ar.id_rol = u.id_rol LEFT JOIN aux_countries ac ON u.id_country = ac.id";
    const ORDER_ARRAY = ['username', 'rol', 'salarioBruto', 'retencionIRPF', 'country_name'];

    function getUsers(): array {
        $stmt = $this->pdo->query(self::SELECT_FROM);
        return $stmt->fetchAll();
    }

    function GetUsersOrderBySalaryDesc(): array {
        $stmt = $this->pdo->query(self::SELECT_FROM . " ORDER BY salarioBruto DESC");
        return $stmt->fetchAll();
    }

    function getStandardUsers(): array {
        $stmt = $this->pdo->query(self::SELECT_FROM . " WHERE nombre_rol='standard'");
        return $stmt->fetchAll();
    }

    function getUsersNamedCarlos(): array {
        $stmt = $this->pdo->query(self::SELECT_FROM . " WHERE username LIKE 'Carlos%'");
        return $stmt->fetchAll();
    }

    function getUsersFilteredByRol(int $idRol): array {
        $stmt = $this->pdo->prepare(self::SELECT_FROM . " WHERE ar.id_rol = :id_rol");
        $stmt->execute(['id_rol' => $idRol]);
        return $stmt->fetchAll();
    }

    function getUsersFilteredByUsername(string $username): array {
        $stmt = $this->pdo->prepare(self::SELECT_FROM . " WHERE username LIKE :username ");
        $stmt->execute(['username' => '%' . $username . '%']);
        return $stmt->fetchAll();
    }

    function getUsersFilteredBySalaryRange(?float $minSalary, ?float $maxSalary): array {
        $query = self::SELECT_FROM . " WHERE ";
        $conditions = [];
        $vars = [];
        if (!is_null($minSalary)) {
            $conditions[] = "salarioBruto >= :minSalary";
            $vars['minSalary'] = $minSalary;
        }
        if (!is_null($maxSalary)) {
            $conditions[] = "salarioBruto <= :maxSalary";
            $vars['maxSalary'] = $maxSalary;
        }

        $query .= implode(" AND ", $conditions) . " ORDER BY salarioBruto";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($vars);
        return $stmt->fetchAll();
    }

    function getUsersFilteredByRetentionRange(?int $minRet, ?int $maxRet): array {
        $query = self::SELECT_FROM . " WHERE ";
        $conditions = [];
        $vars = [];
        if (!is_null($minRet)) {
            $conditions[] = "retencionIRPF >= :minRet";
            $vars['minRet'] = $minRet;
        }
        if (!is_null($maxRet)) {
            $conditions[] = "retencionIRPF <= :maxRet";
            $vars['maxRet'] = $maxRet;
        }

        $query .= implode(" AND ", $conditions) . " ORDER BY retencionIRPF";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($vars);
        return $stmt->fetchAll();
    }

    private function executeQuery(string $query, array $vars): array {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($vars);
        return $stmt->fetchAll();
    }

    
    /**
     * Calcula las condiciones y las variables en base a los filtros
     * @param array $filtros Condiciones que tienen que cumplir
     * @return array con las condiciones y las variables necesarias
     */
    private function select(array $filtros): array {
        $condiciones = [];
        $vars = [];
        if (!empty($filtros['id_rol']) && filter_var($filtros['id_rol'], FILTER_VALIDATE_INT)) {
            $condiciones[] = 'u.id_rol = :id_rol';
            $vars['id_rol'] = $filtros['id_rol'];
        }
        if (!empty($filtros['username'])) {
            $condiciones[] = 'username LIKE :username';
            $vars['username'] = "%$filtros[username]%";
        }
        if (!empty($filtros['min_salar']) && is_numeric($filtros['min_salar'])) {
            $condiciones[] = 'salarioBruto >= :min_salar';
            $vars['min_salar'] = $filtros['min_salar'];
        }
        if (!empty($filtros['max_salar']) && is_numeric($filtros['max_salar'])) {
            $condiciones[] = 'salarioBruto <= :max_salar';
            $vars['max_salar'] = $filtros['max_salar'];
        }
        if (!empty($filtros['min_ret']) && is_numeric($filtros['min_ret'])) {
            $condiciones[] = 'retencionIRPF >= :min_ret';
            $vars['min_ret'] = $filtros['min_ret'];
        }
        if (!empty($filtros['max_ret']) && is_numeric($filtros['max_ret'])) {
            $condiciones[] = 'retencionIRPF <= :max_ret';
            $vars['max_ret'] = $filtros['max_ret'];
        }
        if (!empty($filtros['id_country']) && is_array($filtros['id_country'])) {
            $ids = [];
            $bind = [];
            $i = 1;
            foreach ($filtros['id_country'] as $c) {
                $key = 'id_country' . $i;
                $ids[] = ":$key";
                $bind[$key] = $c;
                $i++;
            }
            $condiciones[] = "id_country IN (" . implode(", ", $ids) . ")";
            $vars = array_merge($vars, $bind);
        }
        return [
            'condiciones' => $condiciones,
            'vars' => $vars
        ];
    }

    /**
     * Filtra por las condiciones pasadas
     * @param array $filtros Condiciones que se pasan
     * @return array Devuelve los datos de los usuarios que cumplen las condiciones
     */
    function filter(array $filtros): array {

        $condsVars = $this->select($filtros);
        $order = $this->getOrder($filtros);

        $campoOrder = self::ORDER_ARRAY[abs($order) - 1];

        if (empty($condsVars['condiciones'])) {
            $query = self::SELECT_FROM . " ORDER BY $campoOrder " . $this->getSentido($order);
            return $this->pdo->query($query)->fetchAll();
        } else {
            $query = self::SELECT_FROM . " WHERE " . implode(" AND ", $condsVars['condiciones']) . " ORDER BY $campoOrder " . $this->getSentido($order);

            return $this->executeQuery($query, $condsVars['vars']);
        }
    }
    
    /*
     * Devuelve el número de registros que cumplen las condiciones
     * @param type $filtros Los filtros a aplicar
     * @return int Número de registros que cumplen la condición 
     */
    function getNumRegFilter(array $filtros): array {

        $condsVars = $this->select($filtros);
        $order = $this->getOrder($filtros);

        $campoOrder = self::ORDER_ARRAY[abs($order) - 1];

        if (empty($condsVars['condiciones'])) {
            $query = self::SELECT_COUNT . " ORDER BY $campoOrder " . $this->getSentido($order);
            return $this->pdo->query($query)->fetchAll();
//            return (int) $this->pdo->prepare($query)->execute($condsVars['vars'])->fetch()['total'];
        } else {
            $query = self::SELECT_COUNT . " WHERE " . implode(" AND ", $condsVars['condiciones']) . " ORDER BY $campoOrder " . $this->getSentido($order);
            return $this->pdo->query($query)->fetchAll();
//            return (int) $this->pdo->prepare($query)->execute($condsVars['vars'])->fetch()['total'];
        }
    }

    /**
     * Devuelve el número de columnas que tienen el array
     * @return int
     */
    public static function getMaxColumnOrder(): int {
        return count(self::ORDER_ARRAY);
    }

    /**
     * 
     * @param array $filtros
     * @return int 
     */
    public function getOrder(array $filtros): int {
        if (!isset($filtros['order']) || abs($filtros['order']) < 1 || abs($filtros['order']) > count(self::ORDER_ARRAY)) {
            $order = 1;
        } else {
            $order = (int) $filtros['order'];
        }
        return $order;
    }

    /**
     * En función de si el número pasado como param es positivo o negativo 
     * devuelve asc o desc para concatenarlo a la query
     * @param int $order 
     * @return type 
     */
    function getSentido(int $order) {
        return ($order >= 0) ? 'asc' : 'desc';
    }
    
    function getPage($filtros) : int{
        if(isset($filtros['page']) && filter_var($filtros['page'], FILTER_VALIDATE_INT) && $filtros['page'] > 0){
            return (int)$filtros['page'];
        }
        else{
            return 1;
        }
    }
}
