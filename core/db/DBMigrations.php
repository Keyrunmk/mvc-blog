<?php

declare(strict_types=1);

namespace App\core\db;

use App\core\Application;
use Exception;

class DBMigrations extends Database
{
    public function rollback(): void
    {
        $appliedMigrations = $this->getAppliedMigrations();
        // $files = scandir(Application::$ROOT_DIR . '/migrations');

        // $toDeleteMigrations = array_diff($files, $appliedMigrations);

        $deletedMigrations = [];
        foreach ($appliedMigrations as $migration) {
            if ($migration === "." || $migration === "..") {
                continue;
            }
            require_once Application::$ROOT_DIR . "/migrations/$migration";
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();
            $this->log("Deleting migration $migration");
            $instance->down();
            $this->log("Deleted migration $migration");
            $deletedMigrations[] = $migration;
        }

        if (!empty($deletedMigrations)) {
            $this->dropMigrationsTable();
            $this->createMigrationsTable();
        } else {
            $this->log("All migrations are deleted");
        }
    }

    public function applyMigrations(): void
    {
        try {
            $this->createMigrationsTable();

            $appliedMigrations = $this->getAppliedMigrations();

            $newMigrations = [];
            $files = scandir(Application::$ROOT_DIR . '/migrations');

            $toApplyMigrations = array_diff($files, $appliedMigrations);

            foreach ($toApplyMigrations as $migration) {
                if ($migration === '.' || $migration === '..') {
                    continue;
                }

                require_once Application::$ROOT_DIR . '/migrations/' . $migration;
                $className = pathinfo($migration, PATHINFO_FILENAME);

                $instance = new $className();
                $this->log("Applying migration $migration");
                $instance->up();
                $this->log("Applied migration $migration");
                $newMigrations[] = $migration;
            }

            if (!empty($newMigrations)) {
                $this->saveMigrations($newMigrations);
            } else {
                $this->log("All migrations are applied");
            }
        } catch (Exception $e) {
            echo ($e);
            echo PHP_EOL . PHP_EOL;
            echo ("No migrations will be applied") . PHP_EOL;
            $this->rollback();
        }
    }

    public function createMigrationsTable(): void
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=INNODB;
        ");
    }

    public function dropMigrationsTable(): void
    {
        $this->pdo->exec("DROP TABLE IF EXISTS migrations");
    }

    public function getAppliedMigrations(): array
    {
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function saveMigrations(array $migrations): void
    {
        $str = implode(",", array_map(fn ($m) => "('$m')", $migrations));
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES
        $str
        ");
        $statement->execute();
    }

    protected function log(string $message): void
    {
        echo '[' . date('Y-m-d H:i:s') . '] - ' . $message . PHP_EOL;
    }
}
