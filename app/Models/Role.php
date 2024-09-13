<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $hidden = [
        'pivot'
    ];

    public function scopeGetAdmin(Builder $query) {

        $query->where('name', 'admin');
    }

    public function scopeGetManager(Builder $query) {

        $query->where('name', 'manager');
    }
}
