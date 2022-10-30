<?php

use App\core\Application;

class m0005_create_permissions_table
{
    public function up()
    {
        $db = Application::$app->db;

        $sql = "CREATE TABLE permissions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255)
        )";

        $db->pdo->exec($sql);
    }

    public function down()
    {
        $db = Application::$app->db;

        $sql = "DROP TABLE permissions";

        $db->pdo->exec($sql);
    }
}
