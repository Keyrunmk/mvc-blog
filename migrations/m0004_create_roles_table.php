<?php

use App\core\Application;

class m0004_create_roles_table
{
    public function up()
    {
        $db = Application::$app->db;

        $sql = "CREATE TABLE roles (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255)
        )";

        $db->pdo->exec($sql);
    }

    public function down()
    {
        $db = Application::$app->db;

        $sql = "DROP TABLE roles";

        $db->pdo->exec($sql);
    }
}
