<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'income',
        'user_id'
    ];

    protected $hidden = [
        'pivot'
    ];

    public function user() {

        return $this->belongsTo(User::class);
    }

    public function addresses() {

        return $this->belongsToMany(Address::class);
    }

    public function scopeLastMonth(Builder $query) {

        $query->where('created_at', '>=', Carbon::now()->subMonth());
    }
}
