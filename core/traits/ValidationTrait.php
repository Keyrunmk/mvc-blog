<?php

namespace App\core\traits;

use App\core\Application;

trait ValidationTrait
{
    private static string $required = "required";
    private static string $string = "string";
    private static string $int = "int";
    private static string $email = "email";
    private static string $min = "min";
    private static string $max = "max";
    private static string $match = "match";
    private static string $unique = "unique";

    public array $errors = [];

    public function validate(array $data): bool
    {
        //iterating over validation rules set in controller validate
        foreach ($data as $attribute => $rules) {
            //value represented by the attribute
            $value = $this->model->$attribute;
            //iterating over rules set in attribute
            foreach ($rules as $rule) {
                $ruleName = $rule;

                if (is_array($ruleName)) {
                    $ruleName = array_key_first($rule);
                }

                if ($ruleName === self::$required && !$value) {
                    $this->addErrorForRule($attribute, self::$required);
                }

                if ($ruleName === self::$string && !preg_match("/^[a-zA-Z-' ]*$/", $value)) {
                    $this->addErrorForRule($attribute, self::$string);
                }

                if ($ruleName === self::$int && !preg_match("/^[0-9]*$/", $value)) {
                    $this->addErrorForRule($attribute, self::$int);
                }

                if ($ruleName === self::$email && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorForRule($attribute, self::$email);
                }

                if ($ruleName === self::$min && strlen($value) < $rule['min']) {
                    $this->addErrorForRule($attribute, self::$min, $rule);
                }

                if ($ruleName === self::$max && strlen($value) > $rule['max']) {
                    $this->addErrorForRule($attribute, self::$max, $rule);
                }

                if ($ruleName === self::$match && $value !== $this->model->$rule['match']) {
                    $this->addErrorForRule($attribute, self::$match, $rule);
                }

                if ($ruleName === self::$unique) {
                    $tableName = $this->model->tableName();
                    $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $attribute = :attr");
                    $statement->bindValue(":attr", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    if ($record) {
                        $this->addErrorForRule($attribute, self::$unique, ['field' => $attribute]);
                    }
                }
            }
        }
        return empty($this->errors);
    }

    public function addErrorForRule(string $attribute, string $rule, $params = []): void
    {
        $message = $this->errorMessages()[$rule] ?? '';

        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }

        $this->errors[$attribute][] = $message;
    }

    public function errorMessages(): array
    {
        return [
            self::$required => "This field is required",
            self::$string => "This field should only contain letters",
            self::$int => "This field must be integer",
            self::$email => "This field must be a valid email address",
            self::$min => "Min length of this field must be {min}",
            self::$max => "Max lenght of this field must be {max}",
            self::$match => "This field must be the same as {match}",
            self::$unique => "Record with this {field} already exists",
        ];
    }

    public function addError(string $attribute, string $message): void
    {
        $this->errors[$attribute][] = $message;
    }

    public function hasError($attribute): bool
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute): string
    {
        return $this->errors[$attribute][0] ?? '';
    }

    public function hashPassword(): void
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }
}
