<?php

namespace app\core\db;

use app\core\Application;
use app\core\exception\CommonException;
use app\core\Model;
use Exception;
use PDO;

abstract class DBModel extends Model
{
    protected string $tableName;
    protected array $attributes;

    abstract public function tableName(): string;

    abstract public function attributes(): array;

    abstract static public function primaryKey(): string;

    public function __construct()
    {
        $this->tableName = $this->tableName();
        $this->attributes = $this->attributes();
    }

    public function save(array $data): int
    {
        try {
            $params = array_map(fn ($attr) => ":$attr", $this->attributes);
            $statement = self::prepare("INSERT INTO $this->tableName (" . implode(',', $this->attributes) . ") VALUES(" . implode(',', $params) . ")");
            foreach ($this->attributes as $attribute) {
                $statement->bindValue(":$attribute", $data[$attribute]);
            }
            $statement->execute();
            return Application::$app->db->pdo->lastInsertId();
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw ($exception->dump());
        }
    }

    public function update(array $data, int $id)
    {
        try {
            $attributes = array_keys($data);
            $sql = array_map(fn ($attr, $param) => "$attr = '$param'", $attributes, $data);
            $statement = self::prepare("UPDATE $this->tableName SET " . implode(', ', $sql) . " WHERE id = $id");
            $statement->execute();
            return true;
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw $exception->dump();
        }
    }

    public function get(array $columns, string $orderBy, string $sortBy)
    {
        try {
            $statement = self::prepare("SELECT " . implode(',', $columns) . " FROM $this->tableName ORDER BY $orderBy $sortBy");
            $statement->execute();
            return $statement->fetchAll();
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw $exception->dump();
        }
    }

    public function findPostsByCategoryId(int $id): object|array
    {
        try {
            $statement = self::prepare("SELECT posts.* FROM posts
                    INNER JOIN categories_posts ON posts.id = categories_posts.post_id
                    INNER JOIN categories ON categories_posts.category_id = categories.id
                    WHERE categories.id = $id");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw ($exception->dump());
        }
    }

    public function findOrFail(int $id): array
    {
        try {
            $statement = self::prepare("SELECT * FROM $this->tableName WHERE id = $id");
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw $exception->dump();
        }
    }

    public function delete(int $id)
    {
        try {
            $statement = self::prepare("DELETE FROM $this->tableName WHERE id = $id");
            $statement->execute();
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw $exception->dump();
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
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw $exception->dump();
        }
        // here static corresponds to the class on which the findOne will be called, user is this case, it's user's tableName
    }

    public static function prepare(string $sql): mixed
    {
        return Application::$app->db->pdo->prepare($sql);
    }
}
