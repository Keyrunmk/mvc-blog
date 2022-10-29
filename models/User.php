<?php

declare(strict_types=1);

namespace App\models;

use App\core\db\DBModel;

class User extends DBModel
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    public int $status = self::STATUS_INACTIVE;
    public string $password = '';
    public string $confirmPassword = '';

    /**
     * Set table name to users
     */
    public function tableName(): string
    {
        return 'users';
    }

    /**
     * set primary key to id
     */
    public static function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return ['firstname', 'lastname', 'email', 'password', 'status'];
    }

    public function getDisplayName(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}
