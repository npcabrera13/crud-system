<?php

namespace Classes;

use Classes\Database;

require_once "Database.php";

class Analytics
{
    protected $_db;

    public function __construct()
    {
        $db = new Database();
        $this->_db = $db->initConnection();
    }

    public function getProductAnalytics()
    {
        $stmt = $this->_db->prepare("
            SELECT d.department, c.category, COUNT(p.id) AS total
            FROM products p
            JOIN departments d ON p.dept_id = d.id
            JOIN category c ON p.category_id = c.id
            GROUP BY d.department, c.category
        ");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getResearchStatusDistribution()
    {
        $stmt = $this->_db->prepare("
            SELECT research_status as label, COUNT(*) as total 
            FROM researches 
            GROUP BY research_status
            ORDER BY FIELD(research_status, 'PROPOSAL', 'ONGOING', 'COMPLETED', 'PUBLISHED')
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPublicationStatusDistribution()
    {
        $stmt = $this->_db->prepare("
            SELECT publication_status as label, COUNT(*) as total 
            FROM researches 
            GROUP BY publication_status
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getResearchByCampus()
    {
        $stmt = $this->_db->prepare("
            SELECT campus as label, COUNT(*) as total 
            FROM researches 
            GROUP BY campus 
            ORDER BY total DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getResearchByCollege()
    {
        $stmt = $this->_db->prepare("
            SELECT college as label, COUNT(*) as total 
            FROM researches 
            GROUP BY college 
            ORDER BY total DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getFacultyStats()
    {
        $stats = [];
        $stmt = $this->_db->prepare("SELECT COUNT(*) FROM faculties");
        $stmt->execute();
        $stats['total'] = $stmt->fetchColumn();

        $stmt = $this->_db->prepare("SELECT COUNT(*) FROM faculties WHERE gender = 'Male'");
        $stmt->execute();
        $stats['male'] = $stmt->fetchColumn();

        $stmt = $this->_db->prepare("SELECT COUNT(*) FROM faculties WHERE gender = 'Female'");
        $stmt->execute();
        $stats['female'] = $stmt->fetchColumn();

        return $stats;
    }
}
