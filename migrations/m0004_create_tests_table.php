<?php

use App\core\Application;

class m0004_create_tests_table
{
    public function up()
    {
        $db = Application::$app->db;

        $sql = "CREATE TABLE tests (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $db->pdo->exec($sql);
    }

    public function down()
    {
        $db = Application::$app->db;

        $sql = "DROP TABLE tests";
        $db->pdo->exec($sql);
    }
}
