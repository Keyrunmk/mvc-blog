<?php

declare(strict_types=1);

namespace App\models;

use App\core\db\DBModel;

class User extends DBModel
{
    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
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
        return ['firstname', 'lastname', 'email', 'password'];
    }

    public function getDisplayName(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}
