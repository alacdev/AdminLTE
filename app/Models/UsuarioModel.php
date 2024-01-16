<?php

namespace Com\Daw2\Models;

use \PDO;

class UsuarioModel extends \Com\Daw2\Core\BaseDbModel {

    const SELECT_FROM = "SELECT u.*, ar.nombre_rol as rol FROM usuario u LEFT JOIN aux_rol ar ON ar.id_rol = u.id_rol";

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
    
    function getUsersFilteredByRetentionRange(?float $minRet, ?float $maxRet): array {
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

//    function getUsersFilteredBySalaryRange(?float $minSalary = NULL, ?float $maxSalary = NULL): array {
//        $stmt = $this->pdo->prepare(self::SELECT_FROM . " WHERE salarioBruto BETWEEN :minSalary AND :maxSalary ");
//        $stmt->execute(['minSalary' =>$minSalary, 'maxSalary' =>$maxSalary]);
//        return $stmt->fetchAll();        
//    } 
}
