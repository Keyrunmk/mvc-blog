<?php

use App\core\Application;

class m0003_create_admins_table
{
    public function up()
    {
        $db = Application::$app->db;
        $sql = "CREATE TABLE admins (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255),
            email VARCHAR(255) UNIQUE,
            password VARCHAR(255),
            remember_token BOOL
        ) ENGINE=INNODB;";
        $db->pdo->exec($sql);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql = "DROP TABLE admins";
        $db->pdo->exec($sql);
    }
}
