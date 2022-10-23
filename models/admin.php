<?php

declare(strict_types=1);

namespace App\models;

use App\core\db\DBModel;

class Admin extends DBModel
{
    public string $email = '';
    public string $password = '';

    public function tableName(): string
    {
        return "admins";
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name',
            'email',
            'password',
        ];
    }

    public static function primaryKey(): string
    {
        return 'id';
    }
}
