<?php

namespace App\Models\Operation;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = [
        'user_id', 'park_id', 'status_id', 'created', 'leaved', "img","address"
    ];
}
