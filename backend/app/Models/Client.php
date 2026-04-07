<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'entity_type',
        'company',
        'phone',
        'email',
        'address',
        'notes',
    ];
}
