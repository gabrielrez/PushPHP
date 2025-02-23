<?php

namespace App\Models;

use Core\Database\Model;

class Kitten extends Model
{
    /**
     * @var string $table The database table associated with the model.
     */
    protected static string $table = 'kittens';

    /**
     * @var array $allowed_fields Fields that can be mass-assigned.
     */
    protected static array $allowed_fields = ['name', 'color'];

    // Add other model-specific methods if needed
}
