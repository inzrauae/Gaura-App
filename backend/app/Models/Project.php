<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name'];

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'project_name', 'name');
    }
}
