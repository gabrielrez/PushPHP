<?php

namespace App\Models;

use Core\Model;

class Kitten extends Model
{
    protected $table = 'kittens';
    protected $allowed_fields = ['name', 'color'];
}
