<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Pokemon extends Model
{
    protected $table = 'pokemons';

    protected $fillable = [
        'name',
        'height',
        'weight'
    ];

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => strtolower($value),
            set: fn (string $value) => strtolower($value),
        );
    }
}
