<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'title',
        'comments',
        'reference',
        'is_archived'
    ];

    public function stage() {
        return $this->belongsTo(Stage::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
