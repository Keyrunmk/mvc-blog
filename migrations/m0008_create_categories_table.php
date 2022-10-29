<?php

use App\core\Application;

class m0008_create_categories_table
{
    public function up()
    {
        $db = Application::$app->db;

        $sql = "CREATE TABLE categories(
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description VARCHAR(255) NOT NULL
        )";

        $db->pdo->exec($sql);
    }

    public function down()
    {
        $db = Application::$app->db;

        $sql = "DROP TABLE categories";

        $db->pdo->exec($sql);
    }
}