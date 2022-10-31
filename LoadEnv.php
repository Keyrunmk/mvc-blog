<?php

declare(strict_types=1);

$data = [];

$env = fopen($envPath, "r") or die("Unable to read .env");

while (!feof($env)) {
    $line = fgets($env);

    $fieldName = getField($line);

    $fieldValue = getData($line, $fieldName);

    $data[trim($fieldName)] = trim($fieldValue);
}

function getField(string $line): string
{
    if (str_contains($line, "=")) {
        $position = strpos($line, "=");
        return substr($line, 0, $position);
    }
}

function getData(string $line, string $fieldName): string
{
    if (str_contains($line, $fieldName)) {
        $position = strpos($line, "=");
        return substr($line, $position+2, strlen($line));
    }
}

fclose($env);