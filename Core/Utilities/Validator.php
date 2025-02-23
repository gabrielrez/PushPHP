<?php

namespace Core\Utilities;

class Validator
{
    /**
     * Validates an array of fields to ensure no field is empty.
     *
     * @param array $fields An associative array of fields to validate, where the key is the field name and the value is the field value.
     * @return array The validated fields, unchanged if all fields are valid.
     * @throws \Exception If any field is empty or contains only whitespace.
     */
    public static function validate(array $fields): array
    {
        foreach ($fields as $field => $value) {
            if (empty(trim($value))) {
                throw new \Exception('The field ' . $field . ' is required.');
            }
        }

        return $fields;
    }
}
