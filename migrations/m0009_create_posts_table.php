<?php

use App\core\Application;

class m0009_create_posts_table
{
    public function up()
    {
        $db = Application::$app->db;

        $sql = "CREATE TABLE posts(
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            status VARCHAR(255) NOT NULL
        )";

        $db->pdo->exec($sql);
    }

    public function down()
    {
        $db = Application::$app->db;

        $sql = "DROP TABLE posts";

        $db->pdo->exec($sql);
    }
}