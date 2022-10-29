<?php

use App\core\Application;

class m0006_create_admins_roles_table
{
    public function up()
    {
        $db = Application::$app->db;

        $sql = "CREATE TABLE admins_roles (
            id INT AUTO_INCREMENT PRIMARY KEY,
            admin_id INT NOT NULL,
            role_id INT NOT NULL
        )";

        $db->pdo->exec($sql);
    }

    public function down()
    {
        $db = Application::$app->db;

        $sql = "DROP TABLE admins_roles";

        $db->pdo->exec($sql);
    }
}
