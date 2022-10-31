<?php

use App\core\Application;

class m0010_create_categories_posts_table
{
    public function up()
    {
        $db = Application::$app->db;

        $sql = "CREATE TABLE categories_posts(
            id INT AUTO_INCREMENT PRIMARY KEY,
            category_id INT NOT NULL,
            post_id INT NOT NULL
        )";

        $db->pdo->exec($sql);
    }

    public function down()
    {
        $db = Application::$app->db;

        $sql = "DROP TABLE categories_posts";

        $db->pdo->exec($sql);
    }
}