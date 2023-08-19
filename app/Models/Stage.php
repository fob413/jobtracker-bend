<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $fillable = [
        'name'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function jobs() {
        return $this->belongsToMany(Job::class);
    }
}
