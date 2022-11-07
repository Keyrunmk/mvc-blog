<?php

declare(strict_types=1);

namespace App\core\db;

use App\core\Application;
use App\core\Model;
use Exception;
use PDO;
use Throwable;

abstract class DBModel extends Model
{
    abstract public function tableName(): string;

    abstract public function attributes(): array;

    abstract static public function primaryKey(): string;

    public function save(array $data): int
    {
        try {
            $attributes = array_keys($data);
            $params = array_map(fn ($attr) => ":$attr", $attributes);
            $statement = self::prepare("INSERT INTO ".$this->tableName()." (" . implode(',', $attributes) . ") VALUES(" . implode(',', $params) . ")");
            foreach ($attributes as $attribute) {
                $statement->bindValue(":$attribute", $data[$attribute]);
            }
            $statement->execute();
            return (int) Application::$app->db->pdo->lastInsertId();
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }

    public function saveByTable(array $data, string $tablename): int
    {
        try {
            $attributes = array_keys($data);
            $params = array_map(fn ($attr) => ":$attr", $attributes);
            $statement = self::prepare("INSERT INTO $tablename (" . implode(',', $attributes) . ") VALUES(" . implode(',', $params) . ")");
            foreach ($attributes as $attribute) {
                $statement->bindValue(":$attribute", $data[$attribute]);
            }
            $statement->execute();
            return (int) Application::$app->db->pdo->lastInsertId();
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }

    public function update(array $data, int $id): bool
    {
        try {
            $attributes = array_keys($data);
            $sql = array_map(fn ($attr, $param) => "$attr = '$param'", $attributes, $data);
            $statement = self::prepare("UPDATE ".$this->tableName()." SET " . implode(', ', $sql) . " WHERE id = $id");
            $statement->execute();
            return true;
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }

    public function get(array $columns = array('*'), string $orderBy = 'id', string $sortBy = 'desc'): array
    {
        try {
            $statement = self::prepare("SELECT " . implode(',', $columns) . " FROM ".$this->tableName()." ORDER BY $orderBy $sortBy");
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }

    public function findManyToManyById(string $firstTable, string $secondTable, string $linkTable, int $id, string $column = "*"): array
    {
        try {
            $firstTable_id = $firstTable . "_id";
            $secondTable_id = $secondTable . "_id";
            $firstTable = $this->makePlural($firstTable);
            $secondTable = $this->makePlural($secondTable);

            $statement = self::prepare("SELECT $firstTable.$column FROM $firstTable
                    INNER JOIN $linkTable ON $firstTable.id = $linkTable.$firstTable_id
                    INNER JOIN $secondTable ON $linkTable.$secondTable_id = $secondTable.id
                    WHERE $secondTable.id = $id");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }

    public function findManyToMany(string $firstTable, string $secondTable, string $linkTable, string $column = "*"): array
    {
        try {
            $firstTable_id = $firstTable . "_id";
            $secondTable_id = $secondTable . "_id";
            $firstTable = $this->makePlural($firstTable);
            $secondTable = $this->makePlural($secondTable);

            $statement = self::prepare("SELECT $firstTable.$column FROM $firstTable
                        INNER JOIN $linkTable ON $firstTable.id = $linkTable.$firstTable_id
                        INNER JOIN $secondTable ON $linkTable.$secondTable_id = $secondTable.id");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }

    private function makePlural(string $tableName): string
    {
        $y = strpos($tableName, "y");
        if ($y) {
            $tableName = substr($tableName, 0, $y);
            return trim($tableName = $tableName . "ies");
        }
        return trim($tableName . "s");
    }

    public function findOrFail(int $id): mixed
    {
        try {
            $statement = self::prepare("SELECT * FROM ".$this->tableName()." WHERE id = $id");
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }

    public function deleteById(int $id): bool
    {
        try {
            $statement = self::prepare("DELETE FROM ".$this->tableName()." WHERE id = $id");
            $statement->execute();
            return true;
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }

    public function delete()
    {
        try {
            $statement = self::prepare("DELETE FROM ".$this->tableName()."");
            $statement->execute();
            return true;
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }

    public static function findOne(array $where): object|bool // [email => test@example.com, firstname => test]
    {
        try {
            $class = new (static::class);
            $tableName = $class->tableName();
            $attributes = array_keys($where);

            $sql = implode("AND", array_map(fn ($attr) => "$attr = :$attr", $attributes));
            $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
            foreach ($where as $key => $item) {
                $statement->bindValue(":$key", $item);
            }

            $statement->execute();
            return $statement->fetchObject(static::class);
        } catch (Exception | Throwable $e) {
            throw $e;
        }
        // here static corresponds to the class on which the findOne will be called, user is this case, it's user's tableName
    }

    public static function findAll(array $where): array // [email => test@example.com, firstname => test]
    {
        try {
            $class = new (static::class);
            $tableName = $class->tableName();
            $attributes = array_keys($where);

            $sql = implode("AND", array_map(fn ($attr) => "$attr = :$attr", $attributes));
            $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
            foreach ($where as $key => $item) {
                $statement->bindValue(":$key", $item);
            }

            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception | Throwable $e) {
            throw $e;
        }
        // here static corresponds to the class on which the findOne will be called, user is this case, it's user's tableName
    }

    public static function prepare(string $sql): mixed
    {
        return Application::$app->db->prepare($sql);
    }
}
