<?php

namespace app\core\traits;

use app\core\Application;

trait ValidationTrait
{
    public static string $required = "required";
    public static string $email = "email";
    public static string $min = "min";
    public static string $max = "max";
    public static string $match = "match";
    public static string $unique = "unique";

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

                if ($ruleName === self::$email && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorForRule($attribute, self::$email);
                }

                if ($ruleName === self::$min && strlen($value) < $rule['min']){
                    $this->addErrorForRule($attribute, self::$min, $rule);
                }

                if ($ruleName === self::$max && strlen($value) > $rule['max']) {
                    $this->addErrorForRule($attribute, self::$max, $rule);
                }

                if ($ruleName === self::$match && $value !== $this->model->$rule['match']) {
                    $this->addErrorForRule($attribute, self::$match, $rule);
                }

                if ($ruleName === self::$unique) {
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr");
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

    public function addErrorForRule(string $attribute, string $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? '';

        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }

        $this->errors[$attribute][] = $message;
    }

    public function errorMessages()
    {
        return [
            self::$required => "This field is required",
            self::$email => "This field must be a valid email address",
            self::$min => "Min length of this field must be {min}",
            self::$max => "Max lenght of this field must be {max}",
            self::$match => "This field must be the same as {match}",
            self::$unique => "Record with this {field} already exists",
        ];
    }

    public function addError(string $attribute, string $message)
    {
        $this->errors[$attribute][] = $message;
    }

    public function hasError($attribute): bool
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? '';
    }

    public function hashPassword(): void
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }
}