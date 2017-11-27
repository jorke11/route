<?php

namespace App\Models\Operation;

use Illuminate\Database\Eloquent\Model;

class Parks extends Model {

    protected $fillable = [
        'stakeholder_id', 'value', 'latitude', 'longitude', 'available', "img","address"
    ];

}
