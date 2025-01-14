<?php

namespace App\Services;

use Core\Utilities\Validator;

class KittenService
{
    public static function validate(array $data)
    {
        try {
            $fields = Validator::validate([
                'name'   => $data['name'],
                'collor' => $data['collor']
            ]);

            return $fields;
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
