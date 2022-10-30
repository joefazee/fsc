<?php

namespace App\Models;

/**
 * Class Company
 *
 * @package \\${NAMESPACE}
 */
class Company
{
    private \mysqli $db;

    public function __construct(\mysqli $db)
    {
        $this->db = $db;
    }

    public function insert($name, $address): bool
    {

        $stmt = $this->db->prepare('INSERT INTO companies (name, address) VALUES (?, ?)');

        $stmt->bind_param('ss', $name, $address);

        return $stmt->execute();
    }

    public function getAll(): array
    {
        $sql = 'SELECT c.id, c.name, c.address, COUNT(e.id) AS e_count
        FROM companies c
        LEFT OUTER  JOIN employees e
        ON e.company_id = c.id
        GROUP BY c.id
        ORDER BY c.created_at DESC
        ';

        $result = $this->db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function find($id)
    {
        $sql = 'SELECT id, name, address FROM companies WHERE id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function employees($companyId): array
    {
        $sql = 'SELECT id, name, phone, email, company_id FROM employees WHERE company_id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $companyId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function addEmployee(string $name, string $phone, string $email, int $companyId)
    {
        $stmt = $this->db->prepare('INSERT INTO employees (name, phone, email, company_id ) VALUES (?, ?, ?, ?)');

        $stmt->bind_param('sssi', $name, $phone, $email, $companyId);

        return $stmt->execute();
    }
}


