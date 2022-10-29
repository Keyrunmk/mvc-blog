<?php

use App\core\Application;

class m0007_create_roles_permissions_table
{
    public function up()
    {
        $db = Application::$app->db;

        $sql = "CREATE TABLE roles_permissions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            role_id INT NOT NULL,
            permission_id INT NOT NULL
        )";

        $db->pdo->exec($sql);
    }

    public function down()
    {
        $db = Application::$app->db;

        $sql = "DROP TABLE roles_permissions";

        $db->pdo->exec($sql);
    }
}
