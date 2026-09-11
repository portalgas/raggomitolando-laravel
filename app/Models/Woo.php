<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Woo extends Model
{
    use SoftDeletes;

    protected $casts = [
        'parent_postid' => 'integer:nullable', 
    ];

    protected $fillable = [
        'deleted_at', // <-- Aggiungi qui per permettere il Mass Assignment
    ];
}
